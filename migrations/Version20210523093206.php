<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523093206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds employees table';
    }

    public function up(Schema $schema): void
    {
        $this->connection->executeQuery(
            <<<SQL
                create table employees
                (
                    uuid char(36) not null,
                    department_uuid char(36) not null,
                    first_name varchar(255) not null,
                    last_name varchar(255) not null,
                    salary_currency varchar(5) not null,
                    salary_value int default 0 not null,
                    years_worked int default 1 not null,
                    constraint employees_pk
                        primary key (uuid),
                    constraint employees_departments_uuid_fk
                        foreign key (department_uuid) references departments (uuid)
                );
                
                create index employees_uuid_index
                    on employees (uuid);

                create index employees_salary_value_index
                    on employees (salary_value);

                create index employees_first_name_index
                    on employees (first_name);
                
                create index employees_last_name_index
                    on employees (last_name);
                
                create index employees_first_name_last_name_index
                    on employees (first_name, last_name);
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeQuery(
            <<<SQL
                drop table employees;
SQL
        );
    }
}
