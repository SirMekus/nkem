<?php

namespace Emmy\Nkem;

class Type
{
    public static function processJsonFile(string $path, string $format = 'php'): string
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException("File does not exist: $path");
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON: " . json_last_error_msg());
        }

        return match ($format) {
            'php' => json_encode(self::replaceTypes($data, 'php'), JSON_PRETTY_PRINT),
            'ts'  => self::buildTsInterface($data),
            default => throw new \InvalidArgumentException("Unsupported format: $format")
        };
    }

    public static function replaceTypes(mixed $input, string $format = 'php'): mixed
    {
        if (is_array($input)) {
            if (self::isAssoc($input)) {
                return array_map(fn($v) => self::replaceTypes($v, $format), $input);
            } else {
                return $format === 'php' ? 'array' : 'Array<any>';
            }
        }

        return self::mapType($input, $format);
    }

    private static function mapType(mixed $value, string $format): string
    {
        $phpType = gettype($value);
        $map = [
            'php' => [
                'boolean' => 'boolean',
                'integer' => 'integer',
                'double'  => 'float',
                'string'  => 'string',
                'array'   => 'array',
                'object'  => 'object',
                'NULL'    => null,
            ],
            'ts' => [
                'boolean' => 'boolean',
                'integer' => 'number',
                'double'  => 'number',
                'string'  => 'string',
                'array'   => 'Array<any>',
                'object'  => 'object',
                'NULL'    => 'null',
            ]
        ];

        return $map[$format][$phpType] ?? 'any';
    }

    private static function isAssoc(array $arr): bool
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public static function buildTsInterface(array $data, string $interfaceName = 'RootType'): string
    {
        $body = self::buildTsStructure($data, 1);
        return "interface {$interfaceName} {\n{$body}}\n";
    }

    private static function buildTsStructure(array $data, int $level): string
    {
        $indent = str_repeat("  ", $level);
        $lines = [];

        foreach ($data as $key => $value) {
            $optional = false;

            if (is_null($value)) {
                $type = 'null';
                $optional = true;
            } elseif (is_array($value)) {
                if (self::isAssoc($value)) {
                    $type = "{\n" . self::buildTsStructure($value, $level + 1) . $indent . "}";
                } else {
                    $type = 'Array<any>';
                }
            } else {
                $type = self::mapType($value, 'ts');
            }

            $line = $indent . $key . ($optional ? "?" : "") . ": $type;";
            $lines[] = $line;
        }

        return implode("\n", $lines) . "\n";
    }
}
