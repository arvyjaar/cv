<?php
/**
 * Created by arvydas.
 * Date: 4/24/17 - Time: 7:28 PM
 */

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('age', array($this, 'ageFilter')),
        );
    }

    public function ageFilter($birthday)
    {
        if ($birthday === null) {
            return 'nenurodytas';
        } else {
            $now = new \DateTime('now');
            $diff = $now->diff($birthday);
            return $diff->y;
        }
    }
}
