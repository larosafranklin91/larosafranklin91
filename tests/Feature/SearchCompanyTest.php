<?php
describe('Search Company Test', function () {
    it('should not return a company by a wrong document', function () {
        $document = '200000191';
        $response = $this->getJson("/api/search-company/{$document}");
        $response->assertStatus(404);

    });

    it('should not return a company by a right document but doesnt stored on RF Database', function () {
        $document = '84068784000180';
        $response = $this->getJson("/api/search-company/{$document}");
        $response->assertStatus(404);

    });

    it('should return a company by a right document and stored on Brazilian Federal Revenue Office', function () {
        $document = '52082033000121';
        $response = $this->getJson("/api/search-company/{$document}");
        $response->assertStatus(200);
    });
});
