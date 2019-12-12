#!/bin/sh
#

git status --porcelain \
  | grep -e '^[AM]\(.*\).php$' \
  | cut -c 3- \
  | xargs -r -n 1 composer sniff-php-file

exit $?;
