# Return list of installed software
require 'facter'
Facter.add(:inventory) do
  setcode do
    Facter::Util::Resolution.exec("/usr/bin/dpkg -l | egrep '^ii' | awk '{ print $2 \"#\" $3; }' | tr '\\n' ';' | bzip2 -9 | uuencode -m inventory")
  end
end
