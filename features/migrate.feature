Feature: Migrate data between databases

  Scenario: Move data 
        Given I am on "/"
        And I wait 1000
        Then I select "CNCFLORA TEST0" from "src"
        And I select "FOACEAE" from "family"
        And I select "Foo bar" from "spp"
        And I select "CNCFLORA TEST1" from "dst"
        And I select "Mover" from "copy_or_move"
        Then I press "Migrar"
        And I wait 1000
        When I request "http://couchdb:5984/cncflora_test1/taxon0"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test1/taxon1"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test1/taxon2"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test1/taxon3"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test1/occ2"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test1/occ1"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test1/prof1"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test1/prof2"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test1/prof0"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test0/taxon0"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test0/taxon1"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test0/taxon2"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test0/taxon3"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test0/occ2"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test0/occ1"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test0/prof1"
        Then the response status should be 404
        When I request "http://couchdb:5984/cncflora_test0/prof2"
        Then the response status should be 200
        When I request "http://couchdb:5984/cncflora_test0/prof0"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test1/taxon/taxon0"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test1/taxon/taxon1"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test1/taxon/taxon2"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test1/taxon/taxon3"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test1/occurrence/occ2"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test1/occurrence/occ1"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test1/profile/prof1"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test1/profile/prof2"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test1/profile/prof0"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test0/taxon/taxon0"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test0/taxon/taxon1"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test0/taxon/taxon2"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test0/taxon/taxon3"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test0/occurrence/occ2"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test0/occurrence/occ1"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test0/profile/prof1"
        Then the response status should be 404
        When I request "http://elasticsearch:9200/cncflora_test0/profile/prof2"
        Then the response status should be 200
        When I request "http://elasticsearch:9200/cncflora_test0/profile/prof0"
        Then the response status should be 200

  Scenario: Invalid combinations
        Given I am on "/"
        And I wait 1000
        Then I select "--" from "src"
        And I select "--" from "family"
        And I select "--" from "spp"
        And I select "--" from "dst"
        And I select "Mover" from "copy_or_move"
        Then I press "Migrar"
        Then I should see "Nada selecionado"
