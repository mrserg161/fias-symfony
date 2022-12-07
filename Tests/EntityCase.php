<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Symfony\LiquetsoftFiasBundle\Tests;

/**
 * Базовый класс для тестирования сущностей.
 */
abstract class EntityCase extends BaseCase
{
    /**
     * Возвращает инициированую сущность для тестирования.
     *
     * @return mixed
     */
    abstract protected function createEntity();

    /**
     * Возвращает массив с проверочными значениями для геттеров и сеттеров.
     *
     * @return array<string, mixed>
     */
    abstract protected function accessorsProvider(): array;

    /**
     * Метод, который получает сущность и массив данных для тестов и проводит
     * тесты.
     */
    public function testAccessors(): void
    {
        foreach ($this->accessorsProvider() as $testKey => $test) {
            $this->assertAccessorsCase($testKey, $test, $test);
        }
    }

    /**
     * Проводит тест аццессоров по указанным параметрам в массиве.
     *
     * @param string $property
     * @param mixed  $input
     * @param mixed  $output
     * @param array  $testCase
     */
    protected function assertAccessorsCase(string $property, $input, $output): void
    {
        $setter = 'set' . ucfirst($property);
        $getter = 'get' . ucfirst($property);
        $entity = $this->createEntity();

        \call_user_func([$entity, $setter], $input);
        $toTest = \call_user_func([$entity, $getter]);
        $this->assertSame(
            $output,
            $toTest,
            "accessor pair {$setter}/{$getter} must returns expected value"
        );
    }
}
