
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Run Shiki highlighting with Sidecar

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/sidecar-shiki.svg?style=flat-square)](https://packagist.org/packages/spatie/sidecar-shiki)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/sidecar-shiki/run-tests?label=tests)](https://github.com/spatie/sidecar-shiki/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/sidecar-shiki/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/sidecar-shiki/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/sidecar-shiki.svg?style=flat-square)](https://packagist.org/packages/spatie/sidecar-shiki)

This package allows you to run [Shiki](https://github.com/shikijs/shiki) on AWS Lambda through [Sidecar](https://github.com/hammerstonedev/sidecar).

You won't need to install Node on your server.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/sidecar-shiki.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/sidecar-shiki)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Requirements

This package requires that `hammerstone/sidecar` has been installed in your Laravel application.

Follow the [Sidecar installation](https://hammerstone.dev/sidecar/docs/main/installation) and [configuration](https://hammerstone.dev/sidecar/docs/main/configuration) instructions.

## Installation

You can install the package via composer:

```bash
composer require spatie/sidecar-shiki
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="sidecar-shiki-config"
```

Register the `HighlightFunction::class` in your `sidecar.php` config file.

```php
/*
 * All of your function classes that you'd like to deploy go here.
 */
'functions' => [
    \Spatie\SidecarShiki\Functions\HighlightFunction::class,
],
```

Deploy the Lambda function by running:

```shell
php artisan sidecar:deploy --activate
```

See [Sidecar documentation](https://hammerstone.dev/sidecar/docs/main/functions/deploying) for details.

## Usage

You can highlight code by calling the `\Spatie\SidecarShiki\SidecarShiki::highlight()` function.

```php
use Spatie\SidecarShiki\SidecarShiki;

SidecarShiki::highlight(
    code: '<?php echo "Hello World"; ?>',
    language: 'php',
    theme: 'github-light',
);
```

The output is this chunk of HTML rendered through AWS Lambdad which will output beautifully in the browser:

```html
<pre class="shiki" style="background-color: #2e3440ff"><code><span class="line"><span style="color: #81A1C1">&lt;?</span><span style="color: #D8DEE9FF">php </span><span style="color: #81A1C1">echo</span><span style="color: #D8DEE9FF"> </span><span style="color: #ECEFF4">&quot;</span><span style="color: #A3BE8C">Hello World</span><span style="color: #ECEFF4">&quot;</span><span style="color: #81A1C1">;</span><span style="color: #D8DEE9FF"> </span><span style="color: #81A1C1">?&gt;</span></span></code></pre>
```

### Marking lines as highlighted, added, deleted or focus

```php
use Spatie\SidecarShiki\SidecarShiki;

// Highlighting lines 1 and 4,5,6
SidecarShiki::highlight(
    code: $code,
    language: 'php',
    highlightLines: [1, '4-6'],
);

// Marking line 1 as added
SidecarShiki::highlight(
    code: $code,
    language: 'php',
    addLines: [1],
);

// Marking line 1 as deleted
SidecarShiki::highlight(
    code: $code,
    language: 'php',
    deleteLines: [1],
);

// Marking line 1 as focus
SidecarShiki::highlight(
    code: $code,
    language: 'php',
    focusLines: [1],
);
```

You can then target these classes in your own CSS to color these lines how you want.

## Testing

The testsuite makes connections to AWS and runs the deployed Lambda function. In order to run the testsuite, you will need an active [AWS account](https://aws.amazon.com/).

We can use the native `sidecar:configure` artisan command to create the necessary AWS credentials for Sidecar. First copy the testbench.example.yaml file to testbench.yaml. Then run `./vendor/bin/testbench sidecar:configure` to start the Sidecar setup process. (You only have to do the setup once)

```shell
cp testbench.yaml.example testbench.yaml
cp .env.example .env
./vendor/bin/testbench sidecar:configure
```

After finishing the Sidecar setup process, you will have received a couple of SIDECAR_* environment variables. Add these credentials to both `.env` and `testbench.yaml`.

Now we can deploy our local `HighlightFunction` to AWS Lambda. Run the following command in your terminal, before executing the testsuite.

```shell
./vendor/bin/testbench sidecar-shiki:setup
```

After the successful deployment, you can run the testsuite.

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rias](https://github.com/spatie)
- [All Contributors](../../contributors)

Special thanks to [Stefan Zweifel]() for his [sidecar-browsershot](https://github.com/stefanzweifel/sidecar-browsershot) package as a big help in how to test this.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
