<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250718100912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movies (ulid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', title VARCHAR(255) NOT NULL, release_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(ulid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moviesession (ulid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', movie_ulid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price DOUBLE PRECISION NOT NULL, PRIMARY KEY(ulid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (ulid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', visitor_ulid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', movie_session_ulid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', status VARCHAR(255) NOT NULL, sold_price DOUBLE PRECISION NOT NULL, sold_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX date_moviesession_idx (sold_date, movie_session_ulid), INDEX visitor_status_idx (visitor_ulid, status), PRIMARY KEY(ulid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor (ulid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(ulid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE moviesession');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE visitor');
    }
}
