class inventory () {
  # Provides uuencode for the inventory fact
  package { "sharutils":
    ensure => installed,
  }
}
