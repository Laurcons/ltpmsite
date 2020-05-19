<templates>

    <template id="situatie-elev-template">

        <div class="d-none d-md-block">
            <div class="row border p-2 font-weight-bold" style="border-bottom-width: 2px;">
                <div class="col-md-3">
                    Materia
                </div>
                <div class="col-md-6">
                    Note și absențe
                </div>
                <div class="col-md-3">
                    Medii
                </div>
            </div>
        </div>
    
        {{#materii}}

            <div class="row border p-2 border-top-0">
            
                <div class="col-md-3">
                    <div style="font-size: 1.4em">{{Nume}}</div>
                    <div class="d-none d-md-block">
                        {{#isSem1}}
                            Media sem 1: <span class="badge badge-primary">{{medie_sem1}}</span>
                        {{/isSem1}}
                        {{#isSem2}}
                            Media sem 2: <span class="badge badge-primary">{{medie_sem2}}</span>
                        {{/isSem2}}
                    </div>
                </div>
                <div class="col-md-6">
                
                    <div data-type="note">
                        <b>Note:</b><br>
                        {{#note}}

                            <div class="nota {{#isTeza}}nota-teza{{/isTeza}}"
                                data-toggle="popover"
                                data-trigger="hover"
                                data-placement="bottom"
                                data-html="true"
                                data-title="Nota {{Nota}} din data {{Ziua}} {{lunaRoman}}"
                                data-content="<b>Acordată la:</b> {{Timestamp}}<br><b>Acordată de:</b> {{profesor.Nume}} {{profesor.Prenume}}<br><b>Obținută la:</b> {{Tip}}">
                                <h4>{{Nota}}
                                    <small>{{Ziua}} {{{lunaRoman}}}</small>
                                </h4>
                            </div>

                        {{/note}}
                        {{^note}}
                            Niciuna încă!
                        {{/note}}
                    </div>
                    <div data-type="absente">
                        <b>Absențe:</b><br>
                        {{#absente}}

                            <div class="absenta"
                                 data-toggle="popover"
                                 data-trigger="hover"
                                 data-placement="bottom"
                                 data-html="true"
                                 data-title="Absența din data de {{Ziua}} {{lunaRoman}}"
                                 data-content="<b>Acordată la:</b> {{Timestamp}}<br><b>Acordată de:</b> {{profesor.Nume}} {{profesor.Prenume}}">
                                <h4>{{Ziua}} {{{lunaRoman}}}</h4>
                            </div>

                        {{/absente}}
                        {{^absente}}
                            Niciuna încă!
                        {{/absente}}
                    </div>

                </div>
                <div class="col-md-3">
                    <b>Media semestrul 1:</b>
                    <span class="badge badge-primary">{{medie_sem1}}</span><br>
                    <b>Media semestrul 2:</b>
                    <span class="badge badge-primary">{{medie_sem2}}</span><br>
                    <b>Media generală:</b>
                    <span class="badge badge-primary">{{medie_gen}}</span><br>
                </div>

            </div>

        {{/materii}}

    </template>

</templates>