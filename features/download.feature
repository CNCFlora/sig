Feature: Download CSV

    Scenario: Family is complete
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "FOACEAE" from "family"
        Then I press "Download CSV"
        Then I should not see a ".alert-warning" element

    Scenario: Family is incomplete
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

    Scenario: Specie is complete
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "FOACEAE" from "family"
        And I wait 5000
        Then I select "Foaceae Specie 01" from "spp"
        Then I press "Download CSV"
        Then I should not see a ".alert-warning" element

    Scenario: Occurrence is duplicated
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 01" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

