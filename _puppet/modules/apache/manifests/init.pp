class apache::run {
    service { apache2:
        enable => true,
        ensure => running,
        hasstatus => true,
        hasrestart => true
    }
}

define apache::vhost(
    $server_name = '*.dev',
    $template = 'apache/dev.erb',
    $site = 'dev',
    $root = '/vagrant/$host/web',
    $controller = 'app_dev.php'
) {
    $sitesavailable = '/etc/apache2/sites-available'
    $sitesenabled = '/etc/apache2/sites-enabled'
    file {"$sitesavailable/$site.conf":
        content => template($template),
        owner   => 'root',
        group   => 'root',
        mode    => '755',
        notify  => Service['apache2']
    }
    file { "$sitesenabled/$site.conf":
        ensure => 'link',
        target => "$sitesavailable/$site.conf",
        notify  => Service['apache2']
    }
}

class apache {
    include apache::run
}
