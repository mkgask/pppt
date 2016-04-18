
execute "initial os check" do
    command <<-"EOH"
apt-get update
apt-get upgrade -y
EOH
end

%w(git autoconf automake libtool make wget bison flex re2c libjpeg-dev libpng12-dev libxml2-dev libbz2-dev libmcrypt-dev libssl-dev libcurl4-openssl-dev libreadline6-dev libtidy-dev libxslt-dev).each do |pkg|
  package pkg
end

execute 'git clone phpenv' do
    command <<-"EOH"
git clone https://github.com/laprasdrum/phpenv.git /home/vagrant/.phpenv
echo 'export PATH="$HOME/.phpenv/bin:$PATH"' >> /home/vagrant/.bashrc
echo 'eval "$(phpenv init -)"' >> /home/vagrant/.bashrc
. /home/vagrant/.bashrc
EOH
    not_if 'ls /home/vagrant |grep .phpenv'
end

execute 'git clone phpenv' do
    command <<-"EOH"
git clone https://github.com/php-build/php-build.git /home/vagrant/.phpenv/plugins/php-build
EOH
    not_if 'ls /home/vagrant/.phpenv/plugins |grep php-build'
end

execute 'install php 7.0.1' do
    command <<-"EOH"
/home/vagrant/.phpenv/bin/phpenv install 7.0.1
/home/vagrant/.phpenv/bin/phpenv global 7.0.1
EOH
    not_if 'ls /home/vagrant/.phpenv/versions |grep 7.0.1'
end

execute 'install composer' do
    command <<-"EOH"
cd /tmp
wget https://getcomposer.org/installer -O composer-setup.php
php -r "if (hash('SHA384', file_get_contents('composer-setup.php')) === '41e71d86b40f28e771d4bb662b997f79625196afcca95a5abf44391188c695c6c1456e16154c75a211d238cc3bc5cb47') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
mv composer-setup.php /usr/local/bin/composer
EOH
    not_if 'ls /usr/local/bin |grep composer'
end

execute 'install phpunit' do
    command <<-"EOH"
cd /vagrant
composer require phpunit/phpunit
sed 's/require/require-dev/' -i composer.json
ln -s /vagrant/vendor/bin/phpunit /usr/local/bin/phpunit
EOH
    not_if '/vagrant/vendor/bin |grep phpunit'
end
