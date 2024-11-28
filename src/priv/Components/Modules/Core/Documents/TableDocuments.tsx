import React, { Component } from 'react'
import Table, { TableProps, TableState } from 'adios/Table';
import { FormProps } from 'adios/Form';
import FormDocument from './FormDocument';

interface TableDocumentsProps extends TableProps {}
interface TableDocumentsState extends TableState {}

export default class TableDocuments extends Table<TableDocumentsProps, TableDocumentsState> {
  static defaultProps = {
    ...Table.defaultProps,
    itemsPerPage: 15,
    formUseModalSimple: true,
    model: 'CeremonyCrmApp/Modules/Core/Documents/Models/Document',
  }

  props: TableDocumentsProps;
  state: TableDocumentsState;

  constructor(props: TableDocumentsProps) {
    super(props);
    this.state = this.getStateFromProps(props);
  }

  getStateFromProps(props: TableDocumentsProps) {
    return {
      ...super.getStateFromProps(props),
    }
  }

  renderForm(): JSX.Element {
    let formProps: FormProps = this.getFormProps();
    return <FormDocument {...formProps}/>;
  }
}