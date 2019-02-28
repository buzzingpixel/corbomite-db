# Corbomite DB

Part of BuzzingPixel's Corbomite project.

This project provides a very thin layer on top of [Atlas](http://atlasphp.io/) to make it available to Corbomite's DI and CLI.

## Usage

When you require this into a Corbomite project, the CLI commands and dependency injection config will automatically be set up. But you will need to set up some environment variables.

### Environment Variables

The following environment variables are optional:

- `DB_DSN_PREFIX` (defaults to `mysql`)
- `DB_HOST` (defaults to `localhost`)
- `DB_CHARSET` (defaults to `utf8mb4`)

The following environment variables need to be set:

- `DB_DATABASE`
- `DB_USER`
- `DB_PASSWORD`
- `CORBOMITE_DB_DATA_NAMESPACE`
- `CORBOMITE_DB_DATA_DIRECTORY`

The last two tell Corbomite/Atlas 1). what namespace to use when creating the data skeleton classes, and 2). what directory to put those classes in.

### Generating the skeleton

`php app db/generate-skeleton`

Run the skeleton generation command on first run and any time your database schema changes so all of Atlas' classes will be set up for you to use.

### Factory

You should inject `\corbomite\db\Factory` into your classes where you need the ORM so you can use the `makeOrm` method on the factory to get a new instance of the ORM.

## License

Copyright 2018 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0).

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
