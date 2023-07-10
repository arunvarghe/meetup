<?php
declare(strict_types=1);

namespace Meetup\Tests\Unit\Form\Type;

use Meetup\Form\Type\MatchFormType;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormBuilderInterface;

class MatchFormTypeTest extends TestCase
{
    public FormBuilderInterface $formBuilder;

    private MatchFormType $matchFormType;

    public function setUp(): void
    {
        $this->formBuilder = m::mock(FormBuilderInterface::class);
        $this->matchFormType = new MatchFormType();
    }

    public function testBuildForm()
    {
        $this->formBuilder->shouldreceive('add')
            ->once();

        $this->matchFormType->buildForm($this->formBuilder, []);

        $this->expectNotToPerformAssertions();
    }
}
