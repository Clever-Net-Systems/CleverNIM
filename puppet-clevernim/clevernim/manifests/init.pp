## clevernim.pp ##
# This manifest pushes the CleverNIM registration script to client machines

class clevernim ($server = "http://clevernim") {
  package { 'curl': ensure => installed }
  file { 'regclevernim':
    path    => '/usr/local/bin/regclevernim',
    ensure  => file,
    content => template("clevernim/regclevernim.erb"),
    mode    => '0755',
    owner   => 'root',
    group   => 'root',
    require => Package['curl'],
  }
  # The following trick prevents the node from appearing blue in the Puppet Dashboard, because execution is done during each run
  # Script execution is done in the unless clause. If everything is OK, the node will appear green in the dashboard, or red if a problem occurred, because /bin/false is executed
  # et le noeud passe en rouge dans la console
  exec { "/usr/local/bin/regclevernim":
    command => "/bin/false",
    cwd => "/usr/local/bin",
    unless => "/usr/local/bin/regclevernim",
    path => [ "/bin", "/usr/bin", "/usr/local/bin" ],
  }
}
