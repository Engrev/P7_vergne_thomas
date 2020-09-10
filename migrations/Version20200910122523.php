<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910122523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bm_customers ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE bm_customers ADD CONSTRAINT FK_E8B9688DA76ED395 FOREIGN KEY (user_id) REFERENCES bm_users (id)');
        $this->addSql('CREATE INDEX IDX_E8B9688DA76ED395 ON bm_customers (user_id)');
        $this->addSql('ALTER TABLE bm_products ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE bm_products ADD CONSTRAINT FK_3C551A41A76ED395 FOREIGN KEY (user_id) REFERENCES bm_users (id)');
        $this->addSql('CREATE INDEX IDX_3C551A41A76ED395 ON bm_products (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bm_customers DROP FOREIGN KEY FK_E8B9688DA76ED395');
        $this->addSql('DROP INDEX IDX_E8B9688DA76ED395 ON bm_customers');
        $this->addSql('ALTER TABLE bm_customers DROP user_id');
        $this->addSql('ALTER TABLE bm_products DROP FOREIGN KEY FK_3C551A41A76ED395');
        $this->addSql('DROP INDEX IDX_3C551A41A76ED395 ON bm_products');
        $this->addSql('ALTER TABLE bm_products DROP user_id');
    }
}
