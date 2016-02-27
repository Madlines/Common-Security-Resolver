# Madlines Common Security Resolver

[![Build Status](https://travis-ci.org/Madlines/Common-Security-Resolver.svg?branch=master)](https://travis-ci.org/Madlines/Common-Security-Resolver)

This is a very simple voters-bases security resolver.
It gets a list of voters which work in a middleware fashion
and it exposes a `isGranted` method which can ask voters if
user can perform a specified task.

Voters don't have to implement any interface. To make that library more generic
it uses duck typing instead. Voters need to be objects implementing one public method
named as you like.

Tasks can be whatever you like. Those can be objects or just string. It's up to your voters
to tell if they support it.

## Usage:

Prepare a voter like that
```php
<?php

class PostEditVoter
{
    public function isGranted($user, $task)
    {
        // if (!($task instanceof PostEditTask)) {
        if ($task !== 'post_edit') {
            return null; // null means 'ignore'
            // returning integer 0 means the same
        }

        if ($user->hasRole('ROLE_ADMIN')) {
            return true; // agree
            // returning integer 1 means the same
        }

        return false; // disagree
        // returning integer -1 means the same
    }
}
```

Create an instance of `AccessResolver` and add voters to it

```php
$postEditVoter = new PostEditVoter();
// create more voters if you like

$resolver = new AccessResolver();

$resolver->addVoter($postEditVoter); // You can pass method name as second parameter. It defaults to `isGranted`
// add more voters if you like

```

Get your user from somewhere

```php
$user = $this->getUser();
```


And ask for permission like that:
```php
$resolver->isGranted($user, 'post_edit');
// or maybe $resolver->isGranted($user, $postEditTask);
```
