
### paiza php power tool

You need to install vagrant and vagrant-itamae.



#### PHP 7.0.1 with Ubuntu/trusty64 in Vagrant

Install [vagrant-itamae](https://github.com/chiastolite/vagrant-itamae).

```
user@pc:~$ vagrant plugin install vagrant-itamae
```

And vagrant up.

```
user@pc:~$ vagrant up
```

PHP7.0.1 is auto build and install with phpenv.
And wait while eating mizu-youkan (Japanese water-jelly) because the time consuming.
After the installation PHP 7.0.1 is complete, log in with SSH.

```
user@pc:~$ vagrant ssh
```

You can create paiza php program in 2nd level directory.

And go to /vagrant directory, you can boot tester.php and your paiza php program test start.

```
vagrant@vagrant-ubuntu-trusty-64:~$ cd /vagrant
vagrant@vagrant-ubuntu-trusty-64:/vagrant$ php tester.php d002
```
