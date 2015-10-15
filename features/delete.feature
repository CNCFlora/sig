Feature: Delete data

  Scenario: Delete some docs
    Given I am on "/delete.php"
    Then I select "CNCFLORA TEST0" from "src"
    And I select "Ocorrência" from "type"
    And I fill in "query" with "*"
    When I press "Buscar"
    And I wait 500
    Then I should see "occ1"
    And I should see "occ2"
    Then I follow "excluir occ1"
    And I follow "VOLTAR"
    Then I select "CNCFLORA TEST0" from "src"
    And I select "Ocorrência" from "type"
    And I fill in "query" with "*"
    When I press "Buscar"
    And I wait 500
    Then I should see "occ2"
    And I should not see "occ1"



