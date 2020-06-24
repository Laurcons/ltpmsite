
<templates>

<template id="resurse-template">
    {{#resurse}}
        <div class="card mb-1">
            <div class="card-header">
                <h4>{{Titlu}}</h4>
            </div>
            <div class="card-body">
                {{{continutRestricted}}}
            </div>
            <div class="card-footer">
                {{#clasa}}<b>Clasa {{clasa}} |</b>{{/clasa}}
                Atașamente: {{atasamente}} |
                Adăugat de: {{profesor.Nume}} {{profesor.Prenume}} |
                Adăugat la: {{Adaugat}}
            </div>
            <a href="/portal/resurse/{{Id}}" class="stretched-link"></a>
        </div>
    {{/resurse}}
</template>

</templates>