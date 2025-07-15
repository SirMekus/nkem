## About Nkem

This is a CLI package that replaces values in a JSON file to their types in either Typescript or JSON.

If you work on developing API, you'll agree that it's important to have a good understanding of the data that's being sent to and from the API/server. This package aims to make that process easier by generating types for your JSON files via feeding it with a sample of an actual response (stored in a JSON file).

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
./vendor/bin/type path/to/your.json ts
```

## Limitations

The types will be generated based on the values in the JSON file. 

Also, if a key can contain "union" types, the package may not be able to interpret it correctly. For example, if the JSON file contains a key that can be either a string or an integer but the value in the given file is a string, the type will be generated as `string`. 

Primarily, the package does the heavy lifting of generating the types for you.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request.

## License

This package is licensed under the MIT License.
