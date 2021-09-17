<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Renter;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class RenterNormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED = 'RENTER_NORMALIZER_ALREADY_CALLED';

    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return Renter::class === $type;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $context['groups'][] = 'renter:editable';

        $context[self::ALREADY_CALLED] = true;

        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }
}
