# Uuid64Php

[![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-v2.0%20adopted-ff69b4.svg)](CODE_OF_CONDUCT.md)
[![CI](https://github.com/Dragonrun1/uuid64php/workflows/CI/badge.svg?branch=main)](https://github.com/Dragonrun1/uuid64php/workflows/CI/badge.svg?branch=main)
[![Coverage Status](https://coveralls.io/repos/github/Dragonrun1/uuid64php/badge.svg?branch=main)](https://coveralls.io/github/Dragonrun1/uuid64php?branch=main)

A UUID v4 (random) library with a new custom compact format which is more web
and database friendly.

## Table Of Contents

* [Installation](#installation)
* [Usage](#usage)
* [Why make this project?](#why-make-this-project)
* [Related Projects](#related-projects)
* [Licenses](#licenses)

## Installation

Use [composer](https://getcomposer.org/download/) to install from
[packagist](https://packagist.org/packages/dragonrun1/uuid64php).

```bash
composer require dragonrun1/uuid64php
```

## Usage

TODO

## Why make this project?

There already exists several fine UUID v4 (random) libraries for PHP, so it
would make little sense to make another one if that was all it did.
In addition to UUIDs this library tries to solve some limitations when trying to
use them on the web and in databases.
I'll detail the database limitation this library tries to overcome next.

### Database Engine Limitation

Database engines be they MySQL, PostgreSQL, SQLite, or any other all have
some way to generate sequences for ID columns. How they do it is nearly
as varies as the engines themselves since ID generation falls outside of the
existing SQL standards, but the result is generally the same in that you end
up with a simple auto-incrementing integer sequence. So where does the
limitation come in and how is it bad? Two words: auto-incrementing and sequence.
Add two more words: bad actors. Combining these four words and some of you may
have started see the possible problems. Next I'll show why combining a bad actor
with the first two words can become an issue.

### The issue with auto-incrementing sequences

First a question for you. How often have you directly exposed a database
table ID in a web form on the Internet? If you are like most developers
including me I think we have all done this without thinking about it
more than once. We may have made it a hidden field but, it's plain to
see for anyone looking directly at the page code. Let's now think about
auto-incrementing sequence and what it can tell us about the underlying
DB table. The universal default for the sequences is they start at 1 and
increase by 1 for each row added to the table. By causing the site to add
a row to the table and looking at that new row we can make a good guess
to how many rows there are in it and by add a second row make a good guess at
how fast it is growing. How is that information useful? What if the
table holds users accounts, and it's their account ID? Now they have some
idea how many actual user accounts they can get in a data breach or are
available to be attacked. Say they get just a list of usernames, and the
IDs which ones should they attack first? I'd attack the first accounts
made as they are likely to be admin or test accounts with greater
access. I'm sure you can think of many other ways that simple incremental
sequences could be attacked that you probably never thought of before I
pointed out the risks.

### Custom base 64 encoding of UUID v4 (random).

An expected use would be in Doctrine entities instead of using auto-increment
IDs.

A UUID is 128-bits long in binary and, most programming language can only
support it in some kind of string or integer array format. Most commonly binary
strings will be used for compactness where strings can contain (nul) chars.
This format normally isn't seem except in functions were the UUID is being
created as it's hard for programmers to visualize it easily. The normal
formatted string version with 36 characters or as a hexadecimal string with 32
characters are much more commonly used. Both of these formats trade off two
times or more memory usage to make them easier to work with. By using a base 64
encoding it increases the memory usage by less than 40 percent (22 chars) over a
binary string (16 chars).

So in summary these are the benefits to using this custom base 64 encoded
format:

  * Database compatible - Can be directly stored in any of the following field
    types: VARCHAR, CHAR, BINARY, etc.
  * URL compatible - Doesn't contain any chars that require special
    escaping in URLs.
  * HTML compatible - Doesn't include any special chars that need to be escaped
    when used in html forms or tag property values. HTML 5 has relaxed the rule
    that required all ID property values to start with a letter.
  * More Human readable - Since base 64 is shorter that other formats most
    people find it easier to read.
  * The best memory to speed trade-off - The binary string takes up the
    least memory but, it needs to be converted to and from other formats
    when using it in URLs etc. which can cause un-needed server load
    issues. The normal and hexadecimal forms are both longer which adds
    to both memory and server load issues. The custom format hits the sweet spot
    where no conversions are required and, it doesn't use a lot of extra
    space either.

## Related Projects

[https://github.com/Dragonrun1/uuid64ts](https://github.com/Dragonrun1/uuid64ts)
Started the __uuid64ts__ project as a translation from this project into
Typescript but along the way ended up feeding back into version 2.0 as well
after issues/bugs in the version 1.0 code had been exposed.

TODO: Since doctrine stuff not included should this be removed?

[https://github.com/Dragonrun1/person_db_skeleton](https://github.com/Dragonrun1/person_db_skeleton)
This project developed in parallel with this project through version 1.0.
They both were based on noticing how many prior projects seem to have these same
common needs for some kind of person object.
I decided to stop reinventing over and over and instead make something that was
easy to re-use in all future projects.

## Licenses

All code is licensed under either of the

* [APACHE] - Apache License, Version 2.0
* [MIT] - MIT License

at your option.

You can find copies of the licenses in the [LICENSE-APACHE] and the
[LICENSE-MIT] files.
All documentation like this README is licensed under the Creative Commons
Attribution-ShareAlike 4.0 International License (CC-BY-SA).
You can find a copy of the [CC-BY-SA] license in the [LICENSE-CC-BY-SA] file.

[APACHE]: https://opensource.org/licenses/Apache-2.0
[CC-BY-SA]: http://creativecommons.org/licenses/by-sa/4.0/
[Contributor Covenant Code of Conduct]: CODE_OF_CONDUCT.md
[LICENSE-APACHE]: LICENSE-APACHE
[LICENSE-CC-BY-SA]: LICENSE-CC-BY-SA
[LICENSE-MIT]: LICENSE-MIT
[MIT]: https://opensource.org/licenses/MIT
[person_db_skeleton]: https://github.com/Dragonrun1/person_db_skeleton

<hr>
Copyright &copy; 2020-present, Michael Cummings<br/>
<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">
<img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" />
</a>
