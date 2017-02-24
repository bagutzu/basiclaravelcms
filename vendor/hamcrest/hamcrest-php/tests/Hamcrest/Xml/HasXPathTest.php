<?php
namespace Hamcrest\Xml;

class HasXPathTest extends \Hamcrest\AbstractMatcherTest
{
    protected static $xml;
    protected static $doc;
    protected static $html;

    public static function setUpBeforeClass()
    {
        self::$xml = <<<XML
<?xml version="1.0"?>
<users>
    <s>
        <id>alice</id>
        <name>Alice Frankel</name>
        <role>admin</role>
    </s>
    <s>
        <id>bob</id>
        <name>Bob Frankel</name>
        <role>s</role>
    </s>
    <s>
        <id>charlie</id>
        <name>Charlie Chan</name>
        <role>s</role>
    </s>
</users>
XML;
        self::$doc = new \DOMDocument();
        self::$doc->loadXML(self::$xml);

        self::$html = <<<HTML
<html>
    <head>
        <title>Home Page</title>
    </head>
    <body>
        <h1>Heading</h1>
        <p>Some text</p>
    </body>
</html>
HTML;
    }

    protected function createMatcher()
    {
        return \Hamcrest\Xml\HasXPath::hasXPath('/users/s');
    }

    public function testMatchesWhenXPathIsFound()
    {
        assertThat('one match', self::$doc, hasXPath('s[id = "bob"]'));
        assertThat('two matches', self::$doc, hasXPath('s[role = "s"]'));
    }

    public function testDoesNotMatchWhenXPathIsNotFound()
    {
        assertThat(
            'no match',
            self::$doc,
            not(hasXPath('s[contains(id, "frank")]'))
        );
    }

    public function testMatchesWhenExpressionWithoutMatcherEvaluatesToTrue()
    {
        assertThat(
            'one match',
            self::$doc,
            hasXPath('count(s[id = "bob"])')
        );
    }

    public function testDoesNotMatchWhenExpressionWithoutMatcherEvaluatesToFalse()
    {
        assertThat(
            'no matches',
            self::$doc,
            not(hasXPath('count(s[id = "frank"])'))
        );
    }

    public function testMatchesWhenExpressionIsEqual()
    {
        assertThat(
            'one match',
            self::$doc,
            hasXPath('count(s[id = "bob"])', 1)
        );
        assertThat(
            'two matches',
            self::$doc,
            hasXPath('count(s[role = "s"])', 2)
        );
    }

    public function testDoesNotMatchWhenExpressionIsNotEqual()
    {
        assertThat(
            'no match',
            self::$doc,
            not(hasXPath('count(s[id = "frank"])', 2))
        );
        assertThat(
            'one match',
            self::$doc,
            not(hasXPath('count(s[role = "admin"])', 2))
        );
    }

    public function testMatchesWhenContentMatches()
    {
        assertThat(
            'one match',
            self::$doc,
            hasXPath('s/name', containsString('ice'))
        );
        assertThat(
            'two matches',
            self::$doc,
            hasXPath('s/role', equalTo('s'))
        );
    }

    public function testDoesNotMatchWhenContentDoesNotMatch()
    {
        assertThat(
            'no match',
            self::$doc,
            not(hasXPath('s/name', containsString('Bobby')))
        );
        assertThat(
            'no matches',
            self::$doc,
            not(hasXPath('s/role', equalTo('owner')))
        );
    }

    public function testProvidesConvenientShortcutForHasXPathEqualTo()
    {
        assertThat('matches', self::$doc, hasXPath('count(s)', 3));
        assertThat('matches', self::$doc, hasXPath('s[2]/id', 'bob'));
    }

    public function testProvidesConvenientShortcutForHasXPathCountEqualTo()
    {
        assertThat('matches', self::$doc, hasXPath('s[id = "charlie"]', 1));
    }

    public function testMatchesAcceptsXmlString()
    {
        assertThat('accepts XML string', self::$xml, hasXPath('s'));
    }

    public function testMatchesAcceptsHtmlString()
    {
        assertThat('accepts HTML string', self::$html, hasXPath('body/h1', 'Heading'));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription(
            'XML or HTML document with XPath "/users/s"',
            hasXPath('/users/s')
        );
        $this->assertDescription(
            'XML or HTML document with XPath "count(/users/s)" <2>',
            hasXPath('/users/s', 2)
        );
        $this->assertDescription(
            'XML or HTML document with XPath "/users/s/name"'
            . ' a string starting with "Alice"',
            hasXPath('/users/s/name', startsWith('Alice'))
        );
    }

    public function testHasAReadableMismatchDescription()
    {
        $this->assertMismatchDescription(
            'XPath returned no results',
            hasXPath('/users/name'),
            self::$doc
        );
        $this->assertMismatchDescription(
            'XPath expression result was <3F>',
            hasXPath('/users/s', 2),
            self::$doc
        );
        $this->assertMismatchDescription(
            'XPath returned ["alice", "bob", "charlie"]',
            hasXPath('/users/s/id', 'Frank'),
            self::$doc
        );
    }
}
