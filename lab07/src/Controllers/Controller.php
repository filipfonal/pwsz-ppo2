<?php

namespace App\Controllers;

use App\Helpers\Result;

class Controller {

	const QUOTES = [
		"Help me, Obi-Wan Kenobi. You're my only hope. - Leia Organa",
		"I find your lack of faith disturbing. - Darth Vader",
		"The Force will be with you. Always. - Obi-Wan Kenobi",
		"Never tell me the odds! - Han Solo",
		"Do. Or do not. There is no try. - Yoda",
		"I’m just a simple man trying to make my way in the universe. - Jango Fett",
	];

	public function getResult(array $request): ?Result {
		if(!isset($request["action"])) {
			return null;
		}

		$action = $this->buildFunctionName($request["action"]);

		if(!method_exists($this, $action)) {
			return null;
		}

		return $this->$action();
	}

	private function buildFunctionName(string $action): string {
		return implode("", ["get", "Random", ucfirst($action)]);
	}

	private function getRandomQuote(): Result {

		$result = new Result();
		$result->title = "Losowy cytat";
		$result->content = self::QUOTES[array_rand(self::QUOTES)];

		return $result;
	}

	private function getRandomRecipe(): Result {
		$recipes = [
			"Składniki: <ul><li>chleb tostowy</li><li>szynka</li><li>ser</li></ul> Przepis: <ul><li>położyć ser i szynkę na kromkę chleba</li><li>przykryć to kromką chleba</li><li>opiec w opiekaczu</li></ul>",
			"Składniki: <ul><li>3 jajka</li><li>3 plastry boczku</li><li>sól</li><li>pieprz</li></ul> Przepis: <ul><li>usmażyć boczek</li><li>wbić nań jajka</li><li>smażyć aż będzie wyglądało apetycznie</li><li>przyprawić</li></ul>",
		];

		$result = new Result();
		$result->title = "Losowy przepis";
		$result->content = $recipes[array_rand($recipes)];

		return $result;
	}

	private function getRandomTrivia(): Result {
		$trivia = [
			"Mango to narodowy owoc Indii, Pakistanu i Filipin.",
			"Konfederacja Tamoios to pierwszy poważny bunt brazylijskich Indian przeciwko Europejczykom.",
			"Ostatnia w Polsce i jedna z ostatnich w Europie epidemia ospy prawdziwej wybuchła latem 1963 roku we Wrocławiu."
		];

		$result = new Result();
		$result->title = "Losowa ciekawostka";
		$result->content = $trivia[array_rand($trivia)];

		return $result;
	}

}
