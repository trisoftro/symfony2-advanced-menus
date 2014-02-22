class {
    'apache':stage => main;
}

apache::vhost {
    'dev':
         server_name => 'dev.accounts.mclowd.com',
         template    => 'apache/dev.erb',
         site        => 'dev.accounts.mclowd.com',
         root        => '/var/www',
         controller  => 'app_dev.php'
}
