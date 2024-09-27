<?php

namespace Lagdo\Symfony\Facades;

use Twig\Extension\ExtensionInterface;
use Twig\Loader\LoaderInterface;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\TokenParser\TokenParserInterface;
use Twig\Cache\CacheInterface;
use Twig\TemplateWrapper;
use Twig\Template;
use Twig\TwigFilter;
use Twig\TwigTest;
use Twig\TwigFunction;
use Twig\Environment;
use Lagdo\Symfony\Facades\AbstractFacade;

/**
 * @method static void enableDebug()
 * @method static void disableDebug()
 * @method static bool isDebug()
 * @method static void enableAutoReload()
 * @method static void disableAutoReload()
 * @method static bool isAutoReload()
 * @method static void enableStrictVariables()
 * @method static bool isStrictVariables()
 * @method static CacheInterface|string|false getCache(bool $original = true)
 * @method static void setCache(CacheInterface|string|false $cache)
 * @method static string render(string|TemplateWrapper $name, array $context = [])
 * @method static string display(string|TemplateWrapper $name, array $context = [])
 * @method static TemplateWrapper load(string|TemplateWrapper $name)
 * @method static TemplateWrapper createTemplate(string $template, string $name = null)
 * @method static bool isTemplateFresh(string $name, int $time)
 * @method static TemplateWrapper|Template resolveTemplate(string|TemplateWrapper|array $names)
 * @method static void setLoader(LoaderInterface $loader)
 * @method static LoaderInterface getLoader()
 * @method static void addRuntimeLoader(RuntimeLoaderInterface $loader)
 * @method static object getRuntime(string $class)
 * @method static void setCharset(string $charset)
 * @method static string getCharset()
 * @method static bool hasExtension(string $class)
 * @method static ExtensionInterface getExtension(string $class)
 * @method static void addExtension(ExtensionInterface $extension)
 * @method static void setExtensions(array $extensions)
 * @method static ExtensionInterface[] getExtensions()
 * @method static TokenParserInterface[] getTags()
 * @method static void addNodeVisitor(NodeVisitorInterface $visitor)
 * @method static void addFilter(TwigFilter $filter)
 * @method static void registerUndefinedFilterCallback(callable $callable)
 * @method static void addTest(TwigTest $test)
 * @method static void addFunction(TwigFunction $function)
 * @method static void registerUndefinedFunctionCallback(callable $callable)
 * @method static void addGlobal(string $name, mixed $value)
 * @method static array mergeGlobals(array $context)
 */
final class View extends AbstractFacade
{
    use ServiceInstance;

    /**
     * @inheritdoc
     */
    protected static function getServiceIdentifier(): string
    {
        return Environment::class;
    }
}
