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

List all available commands

    bin/toggl list

List all available workspaces

	bin/toggl workspace:list

List all available projects (You can omit workspace id to use the one configured in your parameters.yml file)

	bin/toggl project:list [workspace_id] [--filter=my_project_name]

List all available clients (You can omit workspace id to use the one configured in your parameters.yml file)

	bin/toggl client:list [workspace_id] [--filter=my_client_name]

Get client details (You can omit workspace id to use the one configured in your parameters.yml file)

	bin/toggl client:get [client_id]

List last month time entries

	bin/toggl time-entry:list

Configuration
=============

You can add your own preferences inside the auto-generated `app/config/parameters.yml` file.

    - workspace: The configured `workspace` identifier will be used in the `project` command if no argument has been provided
