Toogl-cli
=========

Manage Toggl entries in CLI. Easily.

Installation
============

	composer install

An api_key will be requested. You can find it at [www.toggl.com/app/profile](www.toggl.com/app/profile)
The others parameters are personal settings. If you don't know what to put now, you can keep the default values.

Usage
=====

List all available workspaces

	bin/toggl workspace

List all available projects

	bin/toggl project [workspace_id]

Configuration
=============

You can add your own preferences inside the auto-generated `app/config/parameters.yml` file.

	workspace: The configured `workspace` identifier will be used in the `project` command if no argument has been provided
