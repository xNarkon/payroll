<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210522180517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds departments table';
    }

    public function up(Schema $schema): void
    {
        $this->connection->executeQuery(
            <<<SQL
                create table departments
                (
                    uuid char(36) not null,
                    name varchar(32) not null,
                    salary_supplement_type varchar(32) not null,
                    salary_supplement_value int not null,
                    constraint departments_pk
                        primary key (uuid)
                );
                
                create index departments_uuid_index
                    on departments (uuid);

                create index departments_salary_supplement_type_index
                    on departments (salary_supplement_type);

                create unique index departments_name_uindex
                    on departments (name);
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeQuery(
            <<<SQL
                drop table departments;
SQL
        );
    }
}
