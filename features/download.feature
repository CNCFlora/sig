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
        Then I select "BROMELIACEAE" from "family"
        Then I press "Download CSV"
        Then I should see a ".alert-danger" element

    Scenario: Family occurrences are invalid
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

    Scenario: Occurrence is cultivated
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 02" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

    Scenario: Occurrence is non-native
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 03" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

    Scenario: Occurrence is absent
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 04" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

    Scenario: Occurrence georeference is invalid
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 05" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

    Scenario: Occurrence taxonomy is invalid
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 06" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

    Scenario: Occurrence coordinate precision is not in list
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 07" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-danger" element

    Scenario: Occurrence georeferenceVerification status is not set
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 08" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-danger" element

    Scenario: Occurrence georeferenceVerification status is not valid
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 09" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element

    Scenario: Occurrences do not exist
        Given I am on "/"
        And I wait 1000
        Then I select "cncflora_test0" from "src"
        And I wait 5000
        Then I select "ACANTHACEAE" from "family"
        And I wait 5000
        Then I select "ACANTHACEAE Specie 10" from "spp"
        Then I press "Download CSV"
        Then I should see a ".alert-warning" element
