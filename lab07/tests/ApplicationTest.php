<?php

use App\Controllers\Controller;
use App\Helpers\Result;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase {

	public function testIfEmptyRequestIsHandledProperly(): void {
		$result = $this->getResultFromController([]);
		$this->assertNull($result);
	}

	public function testIfInvalidRequestIsHandledProperly(): void {
		$result = $this->getResultFromController(["test" => "test"]);
		$this->assertNull($result);
	}

	public function testIfInvalidActionIsHandledProperly(): void {
		$result = $this->getResultFromController(["action" => "test"]);
		$this->assertNull($result);
	}

	public function testIfQuoteActionIsHandledProperly(): void {
		$result = $this->getResultFromController(["action" => "quote"]);
		$this->assertNotNull($result);
		$this->assertInstanceOf(Result::class, $result);
		$this->assertContains($result->content, Controller::QUOTES);
	}

	public function testIfRecipeActionIsHandledProperly(): void {
		$result = $this->getResultFromController(["action" => "recipe"]);
		$this->assertNotNull($result);
		$this->assertInstanceOf(Result::class, $result);
	}

	public function testIfTriviaActionIsHandledProperly(): void {
		$result = $this->getResultFromController(["action" => "trivia"]);
		$this->assertNotNull($result);
		$this->assertInstanceOf(Result::class, $result);
	}

	public function testIfQueryActionsHaveProperlyTitle(): void {
		$quoteResult = $this->getResultFromController(["action" => "quote"]);
		$recipeResult = $this->getResultFromController(["action" => "recipe"]);
		$triviaResult = $this->getResultFromController(["action" => "trivia"]);
		$this->assertFalse(is_array($quoteResult->title));
		$this->assertSame("Losowy cytat", $quoteResult->title);
		$this->assertFalse(is_array($recipeResult->title));
		$this->assertSame("Losowy przepis", $recipeResult->title);
		$this->assertFalse(is_array($triviaResult->title));
		$this->assertSame("Losowa ciekawostka", $triviaResult->title);
	}

	public function testIfQueryActionsHaveProperlyContent(): void {
		$quoteResult = $this->getResultFromController(["action" => "quote"]);
		$recipeResult = $this->getResultFromController(["action" => "recipe"]);
		$triviaResult = $this->getResultFromController(["action" => "trivia"]);
		$this->assertTrue(strrpos($recipeResult->content, "<ul>") !== false);
		$this->assertTrue(strrpos($recipeResult->content, "<li>") !== false);
		$this->assertTrue(strlen($quoteResult->content) > 1);
		$this->assertTrue(strlen($triviaResult->content) > 1);
	}

	public function testIfResultClassHaveProperFields(): void {
		$result = new Result();
		$this->assertTrue(property_exists($result, "title"));
		$this->assertTrue(property_exists($result, "content"));
	}

	protected function getResultFromController(array $request): ?Result {
		$controller = new Controller();
		return $controller->getResult($request);
	}

}