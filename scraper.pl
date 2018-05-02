#!/usr/bin/perl

use strict;
use warnings;
use MyMech;
use FindBin qw($Bin);
use HTML::TreeBuilder::LibXML;
use Text::CSV_XS;
use IO::Handle;
use feature qw(say);
use Time::HiRes qw(usleep sleep);

my $config = {

    last_page           => 250,
    output_file         => "$Bin/Result.csv",
    processed_urls_file => "$Bin/Processed_urls.txt",
    columns             => [qw( Name Mar Con Dist Weight OffRaceTime Url)],
    delay               => 500000,
    empty_index => 1,
};

$config->{csv} = Text::CSV_XS->new(
    {
        always_quote => 1,
    }
) or die "Cannot use CSV: " . Text::CSV_XS->error_diag();

open $config->{fh}, ">>:encoding(utf8)", $config->{output_file}
  or die $!;
$config->{fh}->autoflush(1);

open $config->{fh_empty}, ">>:encoding(utf8)", "$Bin/Empty.txt"
  or die $!;
$config->{fh}->autoflush(1);

my $processed_urls = read_processed_urls("$Bin/Result.csv");

say scalar( keys( %{$processed_urls} ) );
my $mech = MyMech->new( cookie_jar => undef );
$mech->agent_alias("Windows IE 6");

foreach my $page_num ( 1 .. $config->{last_page} ) {

    say "[$page_num]";
    my $url =
      "http://www.puntingform.com.au/racing/database/horses/?Page=$page_num";

    next if $processed_urls->{$url};

    my $is_ok = process_page($url);

    if ($is_ok) {

        save_processed_url($url);
        $processed_urls->{$url} = 1;
    }

    usleep( $config->{delay} * 3 );
}

sub process_horse {

    my $url    = shift;
    my $status = 1;

    my $mech = MyMech->new( cookie_jar => undef );
    $mech->agent_alias("Windows IE 6");

    say "\t[$url]";
    
    my $retry_number = 1;
    GET_PAGE:
    eval { $mech->get($url); };
    
    if ($mech->content =~ m/The service is unavailable/) {
      
      sleep(10);
      $retry_number++;
      
      if ($retry_number > 6 ) {
        
        open(my $fh, ">>", "$Bin/Bad.txt") or die $!;
        say {$fh} $url;
        close($fh);
      }
      else {
        goto GET_PAGE;
      }
    }

    unless ($@) {

        my $tree =
          HTML::TreeBuilder::LibXML->new_from_content( $mech->content );

        my $horse_name = $tree->findvalue(
'//h1[@id="ContentPlaceHolderDefault_baseContent_ctl06_HorseViewServerSide_9_EntityTitle"]/text()'
        );

        my @race_nodes = $tree->findnodes(
            '//table[ ./tr[1][./th[1][.="Post."] ] ]/tr[./td[3] ]');

        unless ( scalar(@race_nodes) ) {

            say { $config->{fh_empty} } $url;
            
            #$mech->save_content( "$Bin/Empty_$config->{empty_index}.htm");
            #$config->{empty_index}++;
        }
        else {

            foreach my $result (
                $tree->findnodes(
                    '//table[ ./tr[1][./th[1][.="Post."] ] ]/tr[./td[3] ]')
              )
            {

                my $record = { Name => $horse_name, };

                $record->{Mar}         = $result->findvalue('./td[2]/text()');
                $record->{Con}         = $result->findvalue('./td[11]/text()');
                $record->{Dist}        = $result->findvalue('./td[10]/text()');
                $record->{Weight}      = $result->findvalue('./td[13]/text()');
                $record->{OffRaceTime} = $result->findvalue('./td[23]/text()');
                $record->{Url}         = $url;

                save_record($record);
            }
        }
    }
    else {

        $status = 0;
        warn "$@\n";
    }

    return $status;
}

sub save_record {

    my $record = shift;

    $config->{csv}->combine( @{$record}{ @{ $config->{columns} } } );

    say { $config->{fh} } $config->{csv}->string();
}

sub process_page {

    my $url    = shift;
    my $status = 1;

    my $mech = MyMech->new( cookie_jar => undef );

    eval { $mech->get($url); };

    unless ($@) {

        my $tree =
          HTML::TreeBuilder::LibXML->new_from_content( $mech->content );

        foreach my $horse_url (
            $tree->findvalues('//ul[contains(@class, "column")]/li/a/@href') )
        {

        #http://www.puntingform.com.au/form-guide/horses/winners-pioneer_831148/
            $horse_url = "http://www.puntingform.com.au" . $horse_url;

            next if $processed_urls->{$horse_url};

            my $is_ok = process_horse($horse_url);

            if ($is_ok) {

                save_processed_url($horse_url);
                $processed_urls->{$horse_url} = 1;
            }
            else {

                $status = 0;
                open( my $fh, ">>", "$Bin/Bad_urls.txt" ) or die $!;
                say {$fh} $horse_url;
                close($fh);
            }

            usleep( $config->{delay} );
        }

    }
    else {

        $status = 0;
    }

    return $status;
}

sub read_processed_urls {

    my $file = shift;

    my $processed_urls = {};

    if ( -e $file ) {

        open( my $fh, "<", $file ) or die $!;

        while ( my $row = $config->{csv}->getline($fh) ) {

            next if $. == 1;

            my $url = $row->[-1];
            $url =~ s/^\s+|\s+$//g;

            $processed_urls->{$url} = 1;
        }
        close($fh);
    }

    return $processed_urls;
}

sub save_processed_url {

    my $url = shift;

    open( my $fh, ">>", $config->{processed_urls_file} ) or die $!;
    say {$fh} $url;
    close($fh);
}
