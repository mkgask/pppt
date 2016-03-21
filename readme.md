
## paiza php power tool

You need to install vagrant and vagrant-itamae.



### PHP 7.0.1 with Ubuntu/trusty64 in Vagrant

Install [Vagrant](https://www.vagrantup.com/downloads.html) and [vagrant-itamae](https://github.com/chiastolite/vagrant-itamae) plugin.

```
user@pc:~$ vagrant plugin install vagrant-itamae
```

And vagrant up.

```
user@pc:~$ vagrant up
```

PHP 7.0.1 is installed and automatic build. By phpenv.

Composer and PHPUnit also enters.

And wait while eating mizu-youkan (Japanese water-jelly) because the time consuming.

After the installation PHP 7.0.1 is complete, log in with SSH.

```
user@pc:~$ vagrant ssh
```

You can create paiza php program in 2nd level directory.

And go to /vagrant directory, you can boot ./pppt bash script and your paiza php program test start.

```
vagrant@vagrant-ubuntu-trusty-64:~$ cd /vagrant
vagrant@vagrant-ubuntu-trusty-64:/vagrant$ ./pppt pppt_test
```
