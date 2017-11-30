danielbachhuber/wordcamp-talks-command
======================================

Counts how many times a given topic was presented at a WordCamp.



Quick links: [Using](#using) | [Installing](#installing) | [Contributing](#contributing) | [Support](#support)

## Using

~~~
wp wordcamp-talks <topic> [--year=<year>]
~~~

Uses the WordCamp Central REST API to fetch a list of all WordCamps, and then
searches a given topic against the sessions endpoint for WordCamp.

```
$ wp wordcamp-talks 'WP-CLI' --year=2017
Generating camp URL list...
[...]
https://2017.jackson.wordcamp.org : 1
- AJ Morris: Getting started with WP-CLI, a command-line tool to automate your life
[...]
Total camps for year specified: 120
Camps with WP-CLI talks: 36
Total talks (some camps may have multiple): 48
```

**OPTIONS**

	<topic>
		Topic to search for.

	[--year=<year>]
		Limit results to a specific year. Defaults to current year.

## Installing

Installing this package requires WP-CLI v1.1.0 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with:

    wp package install git@github.com:danielbachhuber/wordcamp-talks-command.git

## Contributing

We appreciate you taking the initiative to contribute to this project.

Contributing isn’t limited to just code. We encourage you to contribute in the way that best fits your abilities, by writing tutorials, giving a demo at your local meetup, helping other users with their support questions, or revising our documentation.

For a more thorough introduction, [check out WP-CLI's guide to contributing](https://make.wordpress.org/cli/handbook/contributing/). This package follows those policy and guidelines.

### Reporting a bug

Think you’ve found a bug? We’d love for you to help us get it fixed.

Before you create a new issue, you should [search existing issues](https://github.com/danielbachhuber/wordcamp-talks-command/issues?q=label%3Abug%20) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version.

Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/danielbachhuber/wordcamp-talks-command/issues/new). Include as much detail as you can, and clear steps to reproduce if possible. For more guidance, [review our bug report documentation](https://make.wordpress.org/cli/handbook/bug-reports/).

### Creating a pull request

Want to contribute a new feature? Please first [open a new issue](https://github.com/danielbachhuber/wordcamp-talks-command/issues/new) to discuss whether the feature is a good fit for the project.

Once you've decided to commit the time to seeing your pull request through, [please follow our guidelines for creating a pull request](https://make.wordpress.org/cli/handbook/pull-requests/) to make sure it's a pleasant experience. See "[Setting up](https://make.wordpress.org/cli/handbook/pull-requests/#setting-up)" for details specific to working on this package locally.

## Support

Github issues aren't for general support questions, but there are other venues you can try: https://wp-cli.org/#support


*This README.md is generated dynamically from the project's codebase using `wp scaffold package-readme` ([doc](https://github.com/wp-cli/scaffold-package-command#wp-scaffold-package-readme)). To suggest changes, please submit a pull request against the corresponding part of the codebase.*
