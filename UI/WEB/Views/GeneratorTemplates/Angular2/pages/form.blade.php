import { Location } from '@angular/common';
import { Component, OnInit, OnDestroy } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { TranslateService } from '@ngx-translate/core';
import { ActivatedRoute } from '@angular/router';

import { {{ $abstractClass = $crud->containerClass('abstract', false, true) }} } from './{{ str_replace('.ts', '', $crud->containerFile('abstract', false, true)) }}';

/**
 * {{ $crud->containerClass('form', false, true) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $crud->containerFile('form', false, true)) }}',
  templateUrl: './{{ $crud->containerFile('form-html', false, true) }}'
})
export class {{ $crud->containerClass('form', false, true) }} extends {{ $abstractClass }} implements OnInit, OnDestroy {
  /**
   * Page title language key.
   * @type string
   */
  protected title: string = 'form-page';

  /**
   * {{ $crud->containerClass('form', false, true) }} constructor.
   */
  public constructor(
    protected titleService: Title,
    protected translateService: TranslateService,
    protected location: Location,
    protected activedRoute: ActivatedRoute,
  ) { super(); }

  /**
   * The component is ready, this is called after the constructor and after the
   * first ngOnChanges(). This is invoked only once when the component is
   * instantiated.
   */
  public ngOnInit() {
    this.setFormType();
    this.setDocumentTitle();
  }

  /**
   * Clean the component canceling the background taks. This is called before the
   * component instance is funally destroyed.
   */
  public ngOnDestroy() {
    this.activedRouteSubscription$ ? this.activedRouteSubscription$.unsubscribe() : null;
  }
}
