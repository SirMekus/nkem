## About Nkem

This is a CLI package that replaces values in a JSON file to their types in either Typescript or JSON.

If you work on developing API, you'll agree that it's important to have a good understanding of the data that's being sent to and from the API/server. This package aims to make that process easier by generating valid "types" for your JSON response(s) via feeding it with a sample of an actual response (stored in a JSON file).

> ##### By the way, "Nkem" is a word that means "my own" in Igbo language.😉

## Installation

To install the package, run:

```bash
composer require sirmekus/nkem
```

## How To Use

After installing the package, run it in your terminal like so:

```bash
./vendor/bin/type path/to/your.json
```

If you want its TypeScript representation, run it like so:

```bash
./vendor/bin/type path/to/your.json --format=ts
```

By default, the generated file will retain the name of the supplied JSON file with "-type" appended to it. You can change this behavior by using the `--name` flag. For example, if you want to name the generated file "custom-name.ts", you can run it like so (without the extension):

```bash
./vendor/bin/type path/to/your.json --format=ts --name=custom-name
```

## Limitations

The types will be generated based on the values in the JSON file. 

Also, if a key can contain a range of possible types (like "string|number"), the package may not be able to interpret it correctly. For example, if the JSON file contains a key whose value can either be a string or an number but the value in the JSON file is a string, its type will be generated as `string`. 

To rectify this limitation, manual interaction may be required for the affected keys after generating the types.

Primarily, the package does the heavy lifting of generating the types for you. 

## Contributing

Of course, there can always be room (and parlour 😁) for improvement. If you have any suggestions or ideas, please feel free to open an issue or submit a pull request.

## License

This package is licensed under the MIT License.
