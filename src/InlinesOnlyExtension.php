<?php

/*
 * This file is part of the league/commonmark-ext-inlines-only package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Ext\InlinesOnly;

use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\Block\Parser as BlockParser;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Inline\Element as InlineElement;
use League\CommonMark\Inline\Parser as InlineParser;
use League\CommonMark\Inline\Processor as InlineProcessor;
use League\CommonMark\Inline\Renderer as InlineRenderer;

final class InlinesOnlyExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $childRenderer = new ChildRenderer();

        $environment
            ->addBlockParser(new BlockParser\LazyParagraphParser(), -200)

            ->addInlineParser(new InlineParser\NewlineParser(),     200)
            ->addInlineParser(new InlineParser\BacktickParser(),    150)
            ->addInlineParser(new InlineParser\EscapableParser(),    80)
            ->addInlineParser(new InlineParser\EntityParser(),       70)
            ->addInlineParser(new InlineParser\EmphasisParser(),     60)
            ->addInlineParser(new InlineParser\AutolinkParser(),     50)
            ->addInlineParser(new InlineParser\HtmlInlineParser(),   40)
            ->addInlineParser(new InlineParser\CloseBracketParser(), 30)
            ->addInlineParser(new InlineParser\OpenBracketParser(),  20)
            ->addInlineParser(new InlineParser\BangParser(),         10)

            ->addInlineProcessor(new InlineProcessor\EmphasisProcessor(), 0)

            ->addBlockRenderer(Document::class, $childRenderer, 0)
            ->addBlockRenderer(Paragraph::class, $childRenderer, 0)

            ->addInlineRenderer(InlineElement\Code::class,       new InlineRenderer\CodeRenderer(),       0)
            ->addInlineRenderer(InlineElement\Emphasis::class,   new InlineRenderer\EmphasisRenderer(),   0)
            ->addInlineRenderer(InlineElement\HtmlInline::class, new InlineRenderer\HtmlInlineRenderer(), 0)
            ->addInlineRenderer(InlineElement\Image::class,      new InlineRenderer\ImageRenderer(),      0)
            ->addInlineRenderer(InlineElement\Link::class,       new InlineRenderer\LinkRenderer(),       0)
            ->addInlineRenderer(InlineElement\Newline::class,    new InlineRenderer\NewlineRenderer(),    0)
            ->addInlineRenderer(InlineElement\Strong::class,     new InlineRenderer\StrongRenderer(),     0)
            ->addInlineRenderer(InlineElement\Text::class,       new InlineRenderer\TextRenderer(),       0)
        ;
    }
}
