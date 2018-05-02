package MyMech;

use WWW::Mechanize;
our @ISA = "WWW::Mechanize";

sub _wrapped {

    my $self   = shift;
    my $method = "SUPER::" . shift;

    my $result;

  RETRY:

    for ( 1 .. 5 ) {

        eval { $result = $self->$method(@_); };

        if ($@) {
            open my $fh, ">>", "error.log" or die $!;
            print {$fh} "[$_]" .  ": $@";
            close $fh;

            $result = undef;
            sleep 12;
        }
        else {

            last RETRY;
        }
    }

    return $result;
}

sub get         { shift->_wrapped( 'get',         @_ ) }
sub post        { shift->_wrapped( 'post',        @_ ) }
sub follow_link { shift->_wrapped( 'follow_link', @_ ) }
sub submit_form { shift->_wrapped( 'submit_form', @_ ) }
sub quiet       { shift->_wrapped( 'quiet',       @_ ) }

1;
