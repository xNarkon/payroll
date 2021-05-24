# Project description

Example of a simple payroll modular-monolith application.

## Bounded Contexts:

- HumanResources - contains whole logic connected to management of departments and employees
- Payroll - contains logic with payroll, and its reporting

# Architecture decisions

Due to the fact that the project is only an example, the simplest, not necessarily the best patterns were used.

## Integration patterns

- Shared Database - Due to the simplicity, I chose to integrate by sharing the database between contexts. It introduces coupling in the data layer, but this is just an example, and it is the easiest way to generate report.
- Integration Events - Used to generate the actual payroll live. Due to the fact that the requirement is to generate only the current report, this method is fully sufficient to generate such reports.

## Technology debt

- MoneyPHP used as a part of a Domain, so it's not totally agnostic - just to simplicity of this project, I used it across all layers. This library implements properly Martin Fowler Money Object pattern, so it guarantees proper money calculations.

# Setup with Docker
Steps to setup a project:

- `docker-compose up -d --force-recreate --build`
- `docker-compose exec php bash`
- `bin/console doctrine:migrations:migrate -n`
- `bin/console hr:initial-fixtures`

### CLI

Available commands:

#### Adds new department
    
Adds new department named Technology with 10% salary supplement
    
    bin/console hr:department:add Technology percentage 10

Adds new department named Support with $100 salary supplement per worked year

    bin/console hr:department:add Technology fixed_amount 10000

On success

    Department successfully added with identifier: 44c4bf06-2b61-4f13-9edc-9f17f87e8259

#### Adds new employee

Adds new employee named Zofia Brynka assigned to department with uuid (9c30868a-02ac-4f43-8bf2-5bf886f1a4f3) with 10 years worked and base salary $2500

    bin/console hr:employee:add Zofia Brynka 9c30868a-02ac-4f43-8bf2-5bf886f1a4f3 10 250000

On success

    Employee successfully added with identifier: 6f52917d-61f4-4f71-a134-5ca7cf9befb5

#### Generates report 

Generates payroll report sorted by department_name ascending and filters records to department_name=HR OR employee_first_name=Ania

    bin/console payroll:report:generate -s department_name -d asc -f department_name=HR,employee_first_name=Ania

On success

    +---------------------+--------------------+------------------+-------------+-----------------+-------------------+----------------+
    | Employee first name | Employee last name | Department       | Base salary | Supplement type | Salary supplement | Payroll salary |
    +---------------------+--------------------+------------------+-------------+-----------------+-------------------+----------------+
    | Ania                | Nowak              | Customer Service | $1,100.00   | percentage      | $110.00           | $1,210.00      |
    | Adam                | Kowalski           | HR               | $1,000.00   | fixed_amount    | $1,000.00         | $2,000.00      |
    +---------------------+--------------------+------------------+-------------+-----------------+-------------------+----------------+

Options

    -s, --sort[=SORT]                      Column sort. Available sorts: [department_name, employee_first_name, employee_last_name, base_salary, salary_supplement_type, supplement_salary_value, final_salary] [default: "employee_first_name"]
    -d, --sort_direction[=SORT_DIRECTION]  Sorting direction [default: "desc"]
    -f, --filters[=FILTERS]                Column filter. Available filters: [department_name, employee_first_name, employee_last_name]. Example syntax: employee_first_name=Ania,department_name=HR

# Other information

## Tests coverage

Just to simplicity tests covers only the most important layers Domain and Application.
