<?php

namespace Gladiator\Aficadev\Core;

class GladTemplateEngine
{
    protected $data = [];
    protected $viewPath;

    public function __construct(array $data = [])
    {
        $this->data = $data;
        $this->viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    }

    public function render($view, $data = [])
{
    $template = $this->viewPath . $view . '.glad.php';

    if (!file_exists($template)) {
        throw new \Exception("Template file not found: $template");
    }

    // Fusionner les données passées avec les données déjà présentes dans la classe
    $mergedData = array_merge($this->data, $data);

    // Extraire les données pour les rendre accessibles dans le template
    extract($mergedData);

    // Charger le contenu du fichier de modèle
    ob_start();
    include $template;
    $content = ob_get_clean();

    // Remplacer les balises {{ }} par les valeurs des variables correspondantes
    $content = preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($mergedData) {
        $expression = trim($matches[1]);
        // Évaluation de l'expression comme une variable si elle est définie dans les données fusionnées
        return $this->evaluateExpression($expression, $mergedData);
    }, $content);

    // Renvoyer le contenu du template compilé
    echo $content;
}

protected function evaluateExpression($expression, $data)
{
    // Si l'expression contient une flèche (->), cela indique une propriété d'objet
    if (strpos($expression, '->') !== false) {
        // Séparer l'expression en parties
        $parts = explode('->', $expression);
        // La première partie est le nom de la variable
        $variable = trim($parts[0]);
        // La deuxième partie est la propriété de l'objet
        $property = trim($parts[1]);
        // Vérifier si la variable existe dans les données fusionnées et est un objet
        if (isset($data[$variable]) && is_object($data[$variable])) {
            // Accéder à la propriété de l'objet
            return htmlspecialchars($data[$variable]->$property ?? '', ENT_QUOTES);
        }
    } else {
        // Si l'expression ne contient pas de flèche (->), elle est traitée comme une variable normale
        return htmlspecialchars($data[$expression] ?? '', ENT_QUOTES);
    }
    // Si aucune correspondance n'est trouvée, renvoyer simplement une chaîne vide
    return '';
}



}
