/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, inject, getTestBed, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';
import { Store } from '@ngrx/store';
import { Router, ActivatedRoute } from '@angular/router';

import * as fromRoot from './../../../reducers';
import { DynamicFormModule } from './../../../dynamic-form/dynamic-form.module';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';

import { {{ $cmpClass = $crud->componentClass('table', $plural = true) }} } from './{{ str_replace('.ts', '', $crud->componentFile('table', true)) }}';
import * as {{ $actions = camel_case($crud->entityName()).'Actions' }} from './../../actions/{{ $crud->slugEntityName() }}.actions';
import { {{ $crud->getLanguageKey(true) }} } from './../../translations/{{ $crud->getLanguageKey() }}';
import { {{ $service = $crud->entityName().'Service' }} } from './../../services/{{ $crud->slugEntityName() }}.service';
import { {{ $model = $crud->entityName() }} } from './../../models/{{ camel_case($crud->entityName()) }}';
import * as utils from './../../utils/{{ $crud->slugEntityName() }}-testing.util';
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * {{ $crud->componentClass('table', $plural = true) }} Tests.
 *
 * @author [name] <[<email address>]>
 */
describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }};
  let testModel: {{ $crud->entityName() }} = utils.{{ $crud->entityName() }}One;
  let reactiveForm;
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let service: {{ $crud->entityName() }}Service;
  let http: Http;
  let router: Router;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [...AUTH_TESTING_COMPONENTS, {{ $cmpClass }}],
      imports: [
        utils.IMPORTS
      ],
      providers: [
        utils.PROVIDERS
      ]
    }).compileComponents();

    store = getTestBed().get(Store);
    router = getTestBed().get(Router);
    http = getTestBed().get(Http);
    service = getTestBed().get({{ $crud->entityName() }}Service);

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);

    fixture = getTestBed().createComponent({{ $cmpClass }});
    component = fixture.componentInstance;
  }));

  beforeEach(inject([TranslateService], (translateService: TranslateService) => {
    translateService.setTranslation('es', ES, true);
    translateService.setDefaultLang('es');
    translateService.use('es');
  }));

  it('should create', () => {
    fixture.detectChanges();
    expect(component).toBeTruthy();
  });

  it('should make certain {{ $service }} calls on ngOnInit', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    expect(service.paginate).toHaveBeenCalled();
    expect(service.getFormModel).not.toHaveBeenCalled();
  }));

  it('should show alert msg on empty list', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    let msgElem = fixture.nativeElement.querySelector('div.alert');

    expect(msgElem).not.toBeNull();
    expect(msgElem.textContent).toContain('{{ trans('crud::templates.no_rows_found') }}');
  }));

  it('should have a table', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    let table = fixture.nativeElement.querySelector('table.table-hover');

    // the table should exists
    expect(table).not.toBeNull();

    // and should have entity attributes as headings
@foreach ($fields as $field)
@if (!$field->hidden)
    expect(table.querySelector('thead tr th.{{ $field->name }}'));
@endif
@endforeach
    
    // should have a "actions" column
    expect(table.querySelector('thead tr th.action'));
  }));

  it('should have body table with action links/buttons', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: utils.{{ $crud->entityName(false) }}List, pagination: {}}]));

    fixture.detectChanges();
    tick();

    let table = fixture.nativeElement.querySelector('table.table-hover');

    expect(table.querySelector('tbody').children.length).toEqual(2); // two rows
    expect(table.querySelector('tbody tr > td a.details-link')).not.toBeNull(); // first row details link
    expect(table.querySelector('tbody tr > td a.edit-link')).not.toBeNull(); // first row edit link
    expect(table.querySelector('tbody tr > td a.delete-link')).not.toBeNull(); // first row delete link
  }));

  it('should emit event/navigate on links click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: utils.{{ $crud->entityName(false) }}List, pagination: {}}]));
    spyOn(router, 'navigateByUrl');

    fixture.detectChanges();
    tick();

    let table = fixture.nativeElement.querySelector('table.table-hover');
    let field = '{{ $fields->first(function ($value) { return $value->on_index_table === true; })->name }}';
    spyOn(store, 'dispatch');

    // table heading links
    table.querySelector('thead tr:first-child th.{{ $crud->tableName }}\\.' + field + ' span').click();

    fixture.detectChanges();
    tick();
    
    expect(store.dispatch).toHaveBeenCalledWith(new {{ $actions }}.SetSearchQueryAction({
      'orderBy': '{{ $crud->tableName }}.' + field,
      'sortedBy': 'asc'
    }));

    // details link click
    table.querySelector('tbody tr:first-child td a.details-link').click();
    fixture.detectChanges();
    
    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $crud->slugEntityName() }}/' + utils.{{ $crud->entityName(false) }}List[0].id + '/details'),
      { skipLocationChange: false, replaceUrl: false }
    );

    // edit link click
    table.querySelector('tbody tr:first-child td a.edit-link').click();
    fixture.detectChanges();
    
    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $crud->slugEntityName() }}/' + utils.{{ $crud->entityName(false) }}List[0].id  + '/edit'),
      { skipLocationChange: false, replaceUrl: false }
    );

    // delete link click
    spyOn(component, 'deleteRow');
    table.querySelector('tbody tr:first-child td a.delete-link').click();
    fixture.detectChanges();
    
    // the component.deleteRow method has full test on {{ $crud->componentClass('form', $plural = false) }}
    expect(component.deleteRow).toHaveBeenCalledWith(utils.{{ $crud->entityName(false) }}List[0].id);
  }));
});
