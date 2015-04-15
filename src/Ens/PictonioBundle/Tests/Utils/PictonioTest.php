<?php
namespace Ens\PictonioBundle\Tests\Utils;
use Ens\PictonioBundle\Utils\Pictonio;
 
class PictonioTest extends \PHPUnit_Framework_TestCase
{
  public function testSlugify()
  {
    $this->assertEquals('sensio', Pictonio::slugify('Sensio'));
    $this->assertEquals('sensio-labs', Pictonio::slugify('sensio labs'));
    $this->assertEquals('sensio-labs', Pictonio::slugify('sensio   labs'));
    $this->assertEquals('paris-france', Pictonio::slugify('paris,france'));
    $this->assertEquals('sensio', Pictonio::slugify('  sensio'));
    $this->assertEquals('sensio', Pictonio::slugify('sensio  '));
    $this->assertEquals('n-a', Pictonio::slugify(''));
    $this->assertEquals('n-a', Pictonio::slugify(' - '));
    if (function_exists('iconv'))
    {
        $this->assertEquals('developpeur-web', Pictonio::slugify('Développeur Web'));
    }
  }
}
