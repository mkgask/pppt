
execute "initial os check" do
    command <<-"EOH"
sudo apt-get update
sudo apt-get upgrade -y
EOH
end

%w(git autoconf automake libtool make wget bison flex re2c libjpeg-dev libpng12-dev libxml2-dev libbz2-dev libmcrypt-dev libssl-dev libcurl4-openssl-dev libreadline6-dev libtidy-dev libxslt-dev).each do |pkg|
  package pkg
end

execute 'reload shell' do
    command <<-"EOH"
. /home/vagrant/.bashrc
EOH
end

execute 'git clone phpenv' do
    command <<-"EOH"
git clone https://github.com/laprasdrum/phpenv.git /home/vagrant/.phpenv
echo 'export PATH="$HOME/.phpenv/bin:$PATH"' >> /home/vagrant/.bashrc
echo 'eval "$(phpenv init -)"' >> /home/vagrant/.bashrc
EOH
    not_if '/home/vagrant/.phpenv'
end

execute 'git clone phpenv' do
    command <<-"EOH"
git clone https://github.com/php-build/php-build.git /home/vagrant/.phpenv/plugins/php-build
EOH
    not_if '/home/vagrant/.phpenv/plugins/php-build'
end

execute 'reload shell' do
    command <<-"EOH"
. /home/vagrant/.bashrc
EOH
end

execute 'install php 7.0.1' do
    command <<-"EOH"
sudo /home/vagrant/.phpenv/bin/phpenv install 7.0.1
sudo /home/vagrant/.phpenv/bin/phpenv global 7.0.1
EOH
    not_if '/home/vagrant/.phpenv/versions/7.0.1'
end
