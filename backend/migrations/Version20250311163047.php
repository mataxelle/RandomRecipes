<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250311163047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, category_id INT DEFAULT NULL, diet_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_DA88B137F92F3E70 (country_id), INDEX IDX_DA88B13712469DE2 (category_id), INDEX IDX_DA88B137E1E13ACE (diet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_season (recipe_id INT NOT NULL, season_id INT NOT NULL, INDEX IDX_7DFA458859D8A214 (recipe_id), INDEX IDX_7DFA45884EC001D1 (season_id), PRIMARY KEY(recipe_id, season_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_ingredient (recipe_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_22D1FE1359D8A214 (recipe_id), INDEX IDX_22D1FE13933FE08C (ingredient_id), PRIMARY KEY(recipe_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, number INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_43B9FE3C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id)');
        $this->addSql('ALTER TABLE recipe_season ADD CONSTRAINT FK_7DFA458859D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_season ADD CONSTRAINT FK_7DFA45884EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE1359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137F92F3E70');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13712469DE2');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137E1E13ACE');
        $this->addSql('ALTER TABLE recipe_season DROP FOREIGN KEY FK_7DFA458859D8A214');
        $this->addSql('ALTER TABLE recipe_season DROP FOREIGN KEY FK_7DFA45884EC001D1');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE1359D8A214');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13933FE08C');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C59D8A214');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_season');
        $this->addSql('DROP TABLE recipe_ingredient');
        $this->addSql('DROP TABLE step');
    }
}
