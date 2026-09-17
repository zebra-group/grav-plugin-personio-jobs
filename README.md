# Personio Jobs Plugin

The **Personio Jobs** Plugin is an extension for [Grav CMS](https://github.com/getgrav/grav).

It fetches, cachees and shows job offerings from Personio.

After every cache clearance the plugin fetches the Persionio XML and caches it in `user/data`.

## Usage

After setting the correct Persionio space URL in config, the twig function `{% set jobs = personio.getJobs() %}` will give you an array, consisting of a revision date and the jobs.

You can skip caching by adding a parameter: `personio.getJobs(true)`.

Template example:

```twig
{% set jobs = personio.getJobs() -%}
<div class="jobs" data-revision="{{ jobs.revision }}">
    <h2 class="title">
        Join our team!
    </h2>
    <ul class="list">
        {% for job in jobs.jobs -%}
            <li class="item">
                <a href="{{ config.plugins['personio-jobs'].source }}/job/{{ job.id }}" class="jobs__entry" target="_blank">
                    {{ job.name }}
                </a>
            </li>
        {% endfor -%}
    </ul>
</div>
```

## Installation

### Installation as dependency (skeleton)

To install the plugin automaticall with `bin/grav install`, add the following to the git section of your `user/.dependecies` file:

```
git:
    personio-jobs:
        url: https://github.com/zebra-group/grav-plugin-personio-jobs
        path: user/plugins/personio-jobs
        branch: main
```

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `personio-jobs`. You can find these files on [GitHub](https://github.com/zebra-group/grav-plugin-personio-jobs) or via [GetGrav.org](https://getgrav.org/downloads/plugins).

You should now have all the plugin files under

    /your/site/grav/user/plugins/personio-jobs
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com/zebra-group/grav-plugin-personio-jobs/blob/main/blueprints.yaml).

## Configuration

Before configuring this plugin, you should copy the `user/plugins/personio-jobs/personio-jobs.yaml` to `user/config/plugins/personio-jobs.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
source: https://example.jobs.personio.de
```

Note that if you use the Admin Plugin, a file with your configuration named personio-jobs.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.
