<?php

namespace DbalUtil\Connection\Postgresql;

use DbalUtil\Connection\ConnectionAbstractTrait;

trait QueryTrait
{
    use ConnectionAbstractTrait;

    public function insert_returning_id(string $table, array $insert) {
        // TODO: (SECURITY) assert $insert is an array DONE
        // TODO: id in parameter
        $conn = $this->getConnection();
        $qb = $conn->createQueryBuilder();
        return $conn->executeQuery('INSERT INTO ' . $table . ' (' . implode(',', array_keys($insert)) . ') ' .
            'VALUES (' . implode(',', array_map([$qb, 'createNamedParameter'], array_values($insert))) . ') RETURNING id')->fetchAll()[0]; // TODO ?
        // SECURITY TODO: Prepared statement DONE
        // TODO: be sure array_keys and array_values are in the same order.
        // TODO: ! Postgres specific
    }

    public function insert_default_uuid_returning_uuid($table, array $insert) {
        // TODO: (SECURITY) assert $insert is an array DONE
        // TODO: id in parameter
        $conn = $this->getConnection();
        $qb = $conn->createQueryBuilder();
        return $conn->executeQuery(
            'INSERT INTO ' . $table . ' (' . implode(',', array_keys($insert)) . ') ' .
                'VALUES (' . implode(',', array_map([$qb, 'createPositionalParameter'], array_values($insert))) . ') RETURNING uuid',
            array_values($insert) // TODO finger crossed that everything keeps in the same order.
        )->fetchAll()[0]; // TODO ?
        // SECURITY TODO: Prepared statement DONE
        // TODO: be sure array_keys and array_values are in the same order.
        // TODO: ! Postgres specific
    }

    public function insert_default_values_returning_id(string $table) { /// TODO: id in parameter
///
        return $this->getConnection()->executeQuery('INSERT INTO ' . $table . ' DEFAULT VALUES RETURNING id')->fetchAll()[0]; // TODO ?
///
        // https://stackoverflow.com/questions/32048634/how-to-get-the-value-of-an-update-returning-query-in-postgresql-in-doctrine
        // TODO: ! Postgres specific
    }

/*
    public function insert_default_values_returning_uuid($table) { /// TODO: id in parameter
///
        // return $conn->executeQuery('INSERT INTO ' . $table . ' DEFAULT VALUES RETURNING uuid')->fetchAll()[0]; // TODO ?
        // return $this->getConnection()->executeQuery('INSERT INTO ' . $table . ' (uuid) VALUES (?) RETURNING uuid', [Uuid::uuid4()])->fetchAll()[0]; // TODO ?
///
        // https://stackoverflow.com/questions/32048634/how-to-get-the-value-of-an-update-returning-query-in-postgresql-in-doctrine
        // TODO: ! Postgres specific
    }
*/

}
