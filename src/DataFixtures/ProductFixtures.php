<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ProductFixtures
 * @package App\DataFixtures
 */
class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * php bin/console doctrine:fixtures:load --append
     */
    public function load(ObjectManager $manager)
    {
        $products = [
            0 => ['OnePlus 7 Pro', 'Aller au-delà de la vitesse.', 'OnePlus', 100, 549.00],
            1 => ['OnePlus 7T', 'Écran 90 Hz. Une Fluidité Inégalée.', 'OnePlus', 100, 539.00],
            2 => ['OnePlus 7T Pro', 'Écran 90 Hz. Une Fluidité Inégalée.', 'OnePlus', 100, 639.00],
            3 => ['OnePlus 8', 'Dirigez avec rapidité.', 'OnePlus', 200, 649.00],
            4 => ['OnePlus 8 Pro', 'Dirigez avec rapidité.', 'OnePlus', 200, 899.00],
            5 => ['OnePlus Nord', 'Tout ce que vous attendiez.', 'OnePlus', 200, 399.00]
        ];

        for ($i=0;$i<6;$i++) {
            $product = new Product();
            $product->setName($products[$i][0])
                ->setDescription($products[$i][1])
                ->setBrand($products[$i][2])
                ->setQuantity($products[$i][3])
                ->setPrice($products[$i][4])
                ->setUser($this->getReference(UserFixtures::USER_REFERENCE))
            ;
            $manager->persist($product);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
