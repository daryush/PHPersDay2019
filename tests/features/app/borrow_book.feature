Feature: Borrow book
  In order to read interesting book without buying it
  As a reader
  I need to be able to borrow book from library

  Scenario: Borrow book
    Given there is reader "john@test.com"
    And there is book "Professional PHP6" with isbn number "9781234567897" that can be borrowed for "20" days
    And today is "02-03-2019"
    When "john@test.com" borrow book "Professional PHP6" marked with isbn "9781234567897"
    Then "john@test.com" library card should contain borrowing of book with isbn "9781234567897"
    And "john@test.com" should return book with isbn "9781234567897" at least on "23-03-2019"

