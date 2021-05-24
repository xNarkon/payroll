<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523175834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds payroll table';
    }

    public function up(Schema $schema): void
    {
        $this->connection->executeQuery(
            <<<SQL
                create table payrolls
                (
                    employee_uuid char(36) not null,
                    supplement_salary_value int not null,
                    supplement_salary_currency varchar(5) not null,
                    final_salary_value int not null,
                    final_salary_currency varchar(5) not null,
                    constraint payrolls_pk
                        primary key (employee_uuid)
                );
                
                create index payrolls_employee_uuid_index
                    on payrolls (employee_uuid);

                create index payrolls_employee_supplement_salary_value_index
                    on payrolls (supplement_salary_value);

                create index payrolls_employee_final_salary_value_index
                    on payrolls (final_salary_value);
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeQuery(
            <<<SQL
                drop table payrolls;
SQL
        );
    }
}
