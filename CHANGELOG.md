CHANGELOG
=========

master
------

Features:

- New component based report generator #851
- HTML Bar Chart component #853
- Data Frame and Expression Filtering #831
- Allow multiple benchmark paths to be specified from CLI #834
- Functions which require at least one value return NULL when values are
  empty #835

Improvement:

- Use automatic time unit for expression report #838

1.0.1 (2021-05-11)
------------------

Bug fix:

- Error with bare report when DateTime used as param #832

1.0.0 (2021-05-09)
------------------

Improvements:

- Optionaly support for binary data in param providers #532
- Support serializable objects in param providers #823

Bug fix:

- Fix regression which requires phpbench to be installed with composer 2 #822

1.0.0-beta2
-----------

B/C breaks:

- Progress logger: startSuite now additionally accepts `RunnerConfig`

Improvements:

- Use package versions to show PHPBench version if not PHAR

Bug fixes:

- Unterminated XML reference #818 - @staabm
- Parent directory for custom script path not created #739 - @alexandrajulius
- Windows newline is not understood in expression language #817 - @dantleech

1.0.0-beta1
-----------

B/C breaks:

- Removed `self-update` functionality (suggest using `phive` instead(.
- Most configuration option names have changed. All options are now prefixed
  by their extension name, e.g. `bootstrap` => `runner.bootstrap`, `path` =>
  `runner.path`, `extensions` => `core.extensions`. See the configuration
  [documentation(https://phpbench.readthedocs.io/en/latest/configuration.html)
  for a full reference.
- Removed `time_unit` and `time_mode` configuration settings, as they are
  replaced by `runner.time_unit` and `runner.time_mode`.
- Environment provider `baseline` renamed to `sampler` to avoid
  concept-conflict with the runner baselines.

Improvements:

- Removed "summary" line from default progress output.
- Automatically detect time or memory units by default, added meta-units
  `time` and `memory`
- Unconditionally enable `xdebug` extension (previously the entire extension
  was hidden if Xdebug wasn't installed)

1.0.0-alpha9
------------

B/C Breaks:

- Extensions grouping related functionalities have been extracted from the
  ``CoreExtension``, this will change the location of some constants used
  (e.g. ``CoreExtension::TAG_PROGRESS_LOGGER`` is now
  ``RunnerExtension::PROGRESS_LOGGER``.
- Renamed `travis` progress logger to `plain`
- Removed awareness of `CONTINUOUS_INTEGRATION` environment variable

Features:

- Added `--working-dir` option
- Option to include the baseline rows in the `expression` report.
- Progress output is sent to STDERR, report output to STDOUT (enable you to
  pipe the output)
- Allow `--theme=` selection and configuration.
- Allow benchmarks to be configued in the config (`runner.{iterations,revs,time_unit,mode,etc}`)
- Include collected environmental information in the report data #789
- Allow providers to be enabled/disabled via. `env.enabled_providers` #789
- Support `@RetryThreshold` annotation, attribute, and
  `runner.retry_threshold` configuration.

Improvements:

- "local" executor will include non-existing benchmark classes and bootstrap
- Configuation options have generated documentation
- Preserve types in env information
- Make default true color theme compatible with light backgrounds.
- Added `vertical` layout to `bare` report (`vertical: true`).
- Removed `best` and `worst` columns by default from default report.
- Default to showing all columns in expression report
- Standard deviation in `default` report is shown as time
- Relative SD is color gradiated
- Trunacte long syntax error messages

Other:

- Automatically sign PHAR on release

1.0.0-alpha8
------------

BC Breaks:

- Removed `table` report generator, it is replaced by the `expression`
  generator which is now used to produce the `default` and `aggregate`
  reports. The output and configuration is largely the same, but some features
  have been removed.
- `html` and `markdown` output formats have been removed temporarily.

Features:

- Introduced `bare` report generator - provides all raw available report data
- Introduced `display_as_time` function to handle formatting time with
  throughput.
- Null `coalesce` function introduced in expression language

Improvements:

- Dynamically resolve timeunit / precision from expression (progress/report) #775
- Support specificaion of display-as precision in expression language
- Allow the display unit to be evaluated (for dynamically determining the unit based on the subject's preference)
- Make the display unit a node - allowing it to be pretty printed.
- Improved memory formatting (thousands separator, use abbreviated suffix)

1.0.0-alpha7
------------

- Support true color expression rendering #767
- Added `expression` report generator - will eventually replace the `table `report used
  for `aggregate` and `default `reports.
- Added `--format` to customize the summary shown in progress loggers
- String concatenation for expression language
- Show debug details (process spawning) with `-vvv`
- Support Xdebug 3

Bug fixes:

- @OutputTimeUnit doesn't propagate to default expression time unit #766

1.0.0-alpha6
------------

- Support for PHP 8 Attributes

1.0.0-alpha5
------------

Backward compatiblity breaks:

- `--uuid` renamed to `--ref` and `tag:` prefix removed #740
- No warnings - if assertion fails within tolerance zone then it is OK
- Assertion DSL has been
  [replaced](https://phpbench.readthedocs.io/en/latest/assertions.html) (only applicable vs. previous alpha
  versions)

Features:

- New [Expression Lanaugage](https://phpbench.readthedocs.io/en/latest/expression.html)

Improvements:

- Show difference to baseline in progress loggers.
- Highlight assertion failures.

1.0.0-alpha-4
-------------

Bug fixes:

- Numeric tags cause an error #717
- Benchmark errors cause reports to error
- Undefined console formatter `subtitle` #729
- Missing formatters not defined in correct place #727

Improvements:

- Colourful indication of success/failure/warnings when assertions are used.
- Allow multiple paths to be specified in config
- Add type restrictions to config values

1.0.0-alpha-3
-------------

Backward compatiblity breaks:

- `BenchmarkExecutorInterface#execute()` must now return an `ExecutionResults`
  object.
- `TemplateExecutor`: expect an `array` for the time measurement result instead
  of an `int`.
- Extensions use the Symfony `OptionsResolver` instead of provding an array of
  default values (which is in line with how other parts of PHPBench are
  working).
- Executors accept a single, immutable `ExecutionContext` instead of the
  mutable `SubjectMetadata` and `Iteration`
- Renamed the `microtime` executor to `remote`.
- `OutputInterface` is injected from the DI conatiner, `OutputAwareInterface`
  has been removed.

Features:

- Introduced `remote_script_remove` and `remote_script_path` options to assist
  in debugging.
- Added `local` executor - execute benchmarks with in the same process as
  PHPBench.

Improvements:

- Decorator added to improve error reporting for method executors.
- Benchmarks executed as they are found (no eager metadata loading)
- Allow direct reference to services (e.g. `--executor=debug` without need for
  a `debug` configuration).

1.0.0-alpha-2
-------------

- PHP 8.0 compatibility

1.0.0-alpha-1
-------------

Backward compatibility breaks:

- DBAL extension removed.
- PHPBench Reports extension removed.
- Removed Xdebug Trace integration
- Removed `--query` featre (only worked with DBAL, too complex).
- Removed `--context` (depreacted in favor of `--tag`).
- Removed `archive` and `delete` commands.
- Assertions now accept a single expression rather than a set of
  configuration options.
- Type hints have been added in most places - possibly causing issues with
  any extensions.
- Assets (storage, xdebug profiles) are now placed in `.phpbench`
- Services referenced via. fully qualified class names instead of strings.

Features:

- Configuration profiles
- Xdebug extension is loaded by default if extension is loaded
- Baseline: Specify baseline suite when running benchmarks and show differences in
  reports #648
- Assert against the baseline
- Show PHP version and the status of Xdebug and Opcache in the runner output
  #649
- Add `@Timeout` to enable a timeout to be specified for any given benchmark -
  @dantleech #614

Improvements

 - All assets now placed in `.phpbench` directory in CWD (instead of
   `./_storage` and `./xdebug`
 - `--tag` implicitly stores the benchmark (no need to additionally use
   `--store`)
 - Decrease benchmark overhead by rendering parameters in-template -
   @marc-mabe

Bugfixes:

 - Use `text` instead of `string` for envrionment key for DBAL storage - @flobee
 - Numeric tags are not found.

0.17.0
------

- Support for Symfony 5
- Dropped support for Symfony < 4.2
- Minimum version of PHP is 7.2

0.16.10
-------

Bug fix:

- Fix PHP 7.4 bug for baseline script (@julien-boudry)

0.16.0
------

BC Break:

- The ExecutorInterface has been
  removed and replaced by the `BenchmarkExecutorInterface`,
  `MethodExecutorInterface` and `HealthCheckInterface`.
- The Executor namespace has been moved from `PhpBench\Benchmark\Executor` to
  `PhpBench\Executor`.

Features:

- Support for named parameters #574
  - Replaces `params` column in reports with `set` (showing param set name) by
    default
  - Progress loggers show param name.
  - Serialized XML documents have a new element `parameter-set` to contain
    parameter elements.

Improvements:

- Various CI and code quality fixes, thanks @localheinz
- `groups` column no longer shown by default in reports.
- HTML report changed from XHTML to HTML5.
- Changed PHPStan level from 1 to 4.

0.15.0
------

- Minimumum supported PHP version is 7.1
- Renamed Factory => MetadataFactory
- Replace Style CI with PHP-CS-Fixer, fixes #537
- Allow any callable as a parameter provider. Fixes #533
- Remove benchmark dependency on JSON extension, use `serialize` instead.
  Fixes #534
- Allow Executor to be specified per benchmark/subject.
- Allow `@ParamProviders` to return a `Generator`. Fixes #529.
- Fix computation exception with `--stop-on-error` and multiple variants #563

0.14.0 Munich
-------------

### Features

- Assertions [docs](http://phpbench.readthedocs.io/en/latest/writing-benchmarks.html#assertions)
- Added `--disable-php-ini` option
- Report if opcode extension is enabled in env.
- Show enabled PHP extensions in env.
- PHP 7 only

### Bugfixes

- Fixed merging of PHP ini config
- Fixed Blackfire integration (#480 @torinaki )

### Improvements

- Internal refactoring!
- Aggregate report: `diff` column now shows multiplier (`x` times slower).
- Various travis imporvements @localheinz 
- Various CS fixes @villfa @Nyholm 
- Microtimer optimization @marc-mabe 
- Symfony 4 support @lcobucci 

0.13.0 Mali Mrack
-----------------

- Bumped minimum requirement to PHP 5.6
- Allow custom subject pattern #449
- No exception for empty file.
- Allow failure on HHVM due to https://github.com/lstrojny/functional-php/issues/114
- Prevent division by zero #451 
- Use non-logarithmic scale for diff column #445

0.12.0 Split
------------

- Column labels
- Non-strict JSON parser (e.g. `--report='extends: aggregate, cols: [ benchmark ]'`
- Dropped JSON schema, introduced Symfony Options Resolver.
- Show better exception message when beforeMethod is static
- Stop on error `run --stop-on-error`
- Allow additional extension autoloader to be configured
- Allow configuration of launcher.
- Refactored annotation reader (allow namespaced annotations, possibility to add benchmark annotations to PHPUnit tests).
- Initial Xdebug function trace support
- Container split into [independent library](https://github.com/phpbench/container)
- Fix skipping benchmarks
