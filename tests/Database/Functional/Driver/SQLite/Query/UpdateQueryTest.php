<?php

declare(strict_types=1);

namespace Cycle\Database\Tests\Functional\Driver\SQLite\Query;

// phpcs:ignore
use Cycle\Database\Tests\Functional\Driver\Common\Query\UpdateQueryTest as CommonClass;

/**
 * @group driver
 * @group driver-sqlite
 */
class UpdateQueryTest extends CommonClass
{
    public const DRIVER = 'sqlite';

    public function testUpdateWithWhereJson(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJson('settings->theme', 'dark');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_extract({settings}, '$.\"theme\"') = ?",
            $select
        );
        $this->assertSameParameters(['value', 'dark'], $select);
    }

    public function testUpdateWithOrWhereJson(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->where('id', 1)
            ->orWhereJson('settings->theme', 'dark');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE {id} = ? OR json_extract({settings}, '$.\"theme\"') = ?",
            $select
        );
        $this->assertSameParameters(['value', 1, 'dark'], $select);
    }

    public function testUpdateWithWhereJsonNested(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJson('settings->phone->work', '+1234567890');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_extract({settings}, '$.\"phone\".\"work\"') = ?",
            $select
        );
        $this->assertSameParameters(['value', '+1234567890'], $select);
    }

    public function testUpdateWithWhereJsonArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJson('settings->phones[1]', '+1234567890');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_extract({settings}, '$.\"phones\"[1]') = ?",
            $select
        );
        $this->assertSameParameters(['value', '+1234567890'], $select);
    }

    public function testUpdateWithWhereJsonNestedArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJson('settings->phones[1]->numbers[3]', '+1234567890');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_extract({settings}, '$.\"phones\"[1].\"numbers\"[3]') = ?",
            $select
        );
        $this->assertSameParameters(['value', '+1234567890'], $select);
    }

    public function testUpdateWithWhereJsonContainsKey(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonContainsKey('settings->languages');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_type({settings}, '$.\"languages\"') IS NOT null",
            $select
        );
    }

    public function testUpdateWithOrWhereJsonContainsKey(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->where('id', 1)
            ->orWhereJsonContainsKey('settings->languages');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE {id} = ? OR json_type({settings}, '$.\"languages\"') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonContainsKeyNested(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonContainsKey('settings->phones->work');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_type({settings}, '$.\"phones\".\"work\"') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonContainsKeyArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonContainsKey('settings->phones[1]');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_type({settings}, '$.\"phones\"[1]') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonContainsKeyNestedArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonContainsKey('settings->phones[1]->numbers[3]');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_type({settings}, '$.\"phones\"[1].\"numbers\"[3]') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonDoesntContainKey(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonDoesntContainKey('settings->languages');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE NOT json_type({settings}, '$.\"languages\"') IS NOT null",
            $select
        );
    }

    public function testUpdateWithOrWhereJsonDoesntContainKey(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->where('id', 1)
            ->orWhereJsonDoesntContainKey('settings->languages');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE {id} = ? OR NOT json_type({settings}, '$.\"languages\"') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonDoesntContainKeyNested(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonDoesntContainKey('settings->phones->work');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE NOT json_type({settings}, '$.\"phones\".\"work\"') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonDoesntContainKeyArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonDoesntContainKey('settings->phones[1]');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE NOT json_type({settings}, '$.\"phones\"[1]') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonDoesntContainKeyNestedArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonDoesntContainKey('settings->phones[1]->numbers[3]');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE NOT json_type({settings}, '$.\"phones\"[1].\"numbers\"[3]') IS NOT null",
            $select
        );
    }

    public function testUpdateWithWhereJsonLengthAndCustomOperator(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonLength('settings->languages', 1, '>=');

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_array_length({settings}, '$.\"languages\"') >= ?",
            $select
        );
        $this->assertSameParameters(['value', 1], $select);
    }

    public function testUpdateWithJsonLength(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->where('id', 1)
            ->whereJsonLength('settings->languages', 3);

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE {id} = ? AND json_array_length({settings}, '$.\"languages\"') = ?",
            $select
        );
        $this->assertSameParameters(['value', 1, 3], $select);
    }

    public function testUpdateWithOrWhereJsonJsonLength(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->where('id', 1)
            ->orWhereJsonLength('settings->languages', 4);

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE {id} = ? OR json_array_length({settings}, '$.\"languages\"') = ?",
            $select
        );
        $this->assertSameParameters(['value', 1, 4], $select);
    }

    public function testUpdateWithWhereJsonLengthNested(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonLength('settings->personal->languages', 1);

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_array_length({settings}, '$.\"personal\".\"languages\"') = ?",
            $select
        );
        $this->assertSameParameters(['value', 1], $select);
    }

    public function testUpdateWithWhereJsonLengthArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonLength('settings->phones[1]', 2);

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_array_length({settings}, '$.\"phones\"[1]') = ?",
            $select
        );
        $this->assertSameParameters(['value', 2], $select);
    }

    public function testUpdateWithWhereJsonLengthNestedArray(): void
    {
        $select = $this->database
            ->update('table')
            ->values(['some' => 'value'])
            ->whereJsonLength('settings->phones[1]->numbers[3]', 5);

        $this->assertSameQuery(
            "UPDATE {table} SET {some} = ? WHERE json_array_length({settings}, '$.\"phones\"[1].\"numbers\"[3]') = ?",
            $select
        );
        $this->assertSameParameters(['value', 5], $select);
    }
}
