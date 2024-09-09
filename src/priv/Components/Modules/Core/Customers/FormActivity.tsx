import React, { Component } from "react";
import Form, { FormProps, FormState } from "adios/Form";
import InputTags2 from "adios/Inputs/Tags2";
import FormInput from "adios/FormInput";
import { CeremonyCrmApp } from "src/priv/Components";

interface FormActivityProps extends FormProps {}

interface FormActivityState extends FormState {}

export default class FormActivity<P, S> extends Form<FormActivityProps,FormActivityState> {
  static defaultProps: any = {
    model: "CeremonyCrmApp/Modules/Core/Customers/Models/Activity",
  };

  props: FormActivityProps;
  state: FormActivityState;

  constructor(props: FormActivityProps) {
    super(props);
    this.state = this.getStateFromProps(props);
  }

  getStateFromProps(props: FormActivityProps) {
    return {
      ...super.getStateFromProps(props),
    };
  }

  normalizeRecord(record) {
    if (record.TAGS) record.TAGS.map((item: any, key: number) => {
      record.TAGS[key].id_activity = {_useMasterRecordId_: true};
    });

    return record;
  }

  renderTitle(): JSX.Element {
    return (
      <>
        <h2>
          {this.state.record.last_name
            ? this.state.record.subject
            : "[no-name]"}
        </h2>
      </>
    );
  }

  onBeforeSaveRecord(record: any) {
    if (record.id == -1) {
      record.completed = 0;
      record.id_user = globalThis.app.idUser;
    }

    return record;
  }

  renderContent(): JSX.Element {
    const R = this.state.record;
    const showAdditional = R.id > 0 ? true : false;

    return (
      <>
        <div className="grid grid-cols-2 gap-1">
          <div>
            <div className="card mt-4">
              <div className="card-header">Activity Information</div>
              <div className="card-body">
                {this.inputWrapper("subject")}
                {this.inputWrapper("id_company")}
                {this.inputWrapper("due_date")}
                {this.inputWrapper("due_time")}
                {this.inputWrapper("duration")}
                {showAdditional ? this.inputWrapper("completed") : null}
                {showAdditional ? this.inputWrapper("id_user") : null}

                <FormInput title='Categories'>
                  <InputTags2 {...this.getDefaultInputProps()}
                    value={this.state.record.TAGS}
                    model='CeremonyCrmApp/Modules/Core/Customers/Models/Tag'
                    targetColumn='id_activity'
                    sourceColumn='id_tag'
                    colorColumn='color'
                    onChange={(value: any) => {
                      this.updateRecord({TAGS: value});
                    }}
                  ></InputTags2>
                </FormInput>
              </div>
            </div>
          </div>
        </div>
      </>
    );
  }
}
