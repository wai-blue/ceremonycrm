import React, { Component, useState } from "react";
import { formatDate } from '@fullcalendar/core'
import FullCalendar from '@fullcalendar/react'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list';
import FormActivity, { FormActivityProps, FormActivityState } from "../Customers/FormActivity";
import ModalSimple from "adios/ModalSimple";
import { getUrlParam } from "adios/Helper";

interface CalendarProps {
  views?: string,
  url?: string,
  height?: any
}

interface CalendarState {
  events: Array<any>,
  showIdActivity?: number,
  newFormDateTime?: string,
  newDate?: string,
  newTime?: string,
}

export default class CalendarComponent extends Component<CalendarProps, CalendarState> {
  constructor(props) {
    super(props);

    this.state = {
      events: [],
      showIdActivity: 0,
      newDate: "",
      newTime: "",
    };
  }

  reselvoNewDateTime = (info) => {
    const year = info.date.getFullYear();
    const month = String(info.date.getMonth() + 1).padStart(2, '0');
    const day = String(info.date.getDate()).padStart(2, '0');

    const hours = String(info.date.getHours()).padStart(2, '0');
    const minutes = String(info.date.getMinutes()).padStart(2, '0');
    const seconds = String(info.date.getSeconds()).padStart(2, '0');

    const dateString = `${year}-${month}-${day}`;
    const timeString = `${hours}:${minutes}:${seconds}`;

    this.setState({
      newTime: timeString,
      newDate: dateString,
      showIdActivity: 0,
    })
  }

  renderCell = (eventInfo) => {
    return (
      <>
        <b>{eventInfo.timeText}</b><span style={{marginLeft: 4}}>{eventInfo.event.title}</span><i style={{marginLeft: 4}}>({eventInfo.event.extendedProps.company})</i>
      </>
    )
  }

  render(): JSX.Element {
    console.log(this.state.newTime);

    return (
      <div>
        <FullCalendar
          eventClassNames={"truncate cursor-pointer"}
          height={this.props.height}
          plugins={[dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin]}
          firstDay={1}
          headerToolbar={{
            left: 'prev,next today',
            center: 'title',
            right: this.props.views ?? 'dayGridMonth,timeGridWeek,timeGridDay'
          }}
          initialView='dayGridMonth'
          eventTimeFormat={{
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false,
            hour12: false,
          }}
          editable={false}
          selectable={false}
          selectMirror={false}
          dayMaxEvents={true}
          weekends={true}
          events={{url: this.props.url}}
          //initialEvents={this.state.events} // alternatively, use the `events` setting to fetch from a feed
          //select={handleDateSelect}
          dateClick={(info) => this.reselvoNewDateTime(info)}
          eventContent={this.renderCell} // custom render function
          eventClick={(eventClickInfo) => {
            this.setState({
              showIdActivity: parseInt(eventClickInfo.event.id),
              newDate: "",
              newTime: "",
            })}
          }
          //eventsSet={handleEvents}
        />

        {this.state.showIdActivity <= 0 ? null :
          <ModalSimple
            uid='activity_form'
            isOpen={true}
            type='right'
          >
            <FormActivity
              id={this.state.showIdActivity}
              descriptionSource="both"
              onDeleteCallback={() => { this.setState({showIdActivity: 0}); }}
              description={{
                permissions: {
                  canDelete: true,
                  canRead: true,
                  canCreate: true,
                  canUpdate: true,
                }
              }}
              showInModal={true}
              showInModalSimple={true}
              onClose={() => { this.setState({showIdActivity: 0}); }}
              onSaveCallback={(form: FormActivity<FormActivityProps, FormActivityState>, saveResponse: any) => {
                if (saveResponse.status = "success") this.setState({showIdActivity: 0});
              }}
            ></FormActivity>
          </ModalSimple>
        }

        {this.state.newDate == "" && this.state.newTime == "" ? null :
          <ModalSimple
            uid='activity_form'
            isOpen={true}
            type='right'
          >
            <FormActivity
              id={-1}
              descriptionSource="both"
              isInlineEditing={true}
              description={{
                defaultValues: {
                  date_start: this.state.newDate,
                  time_start: this.state.newTime == "00:00:00" ? null : this.state.newTime,
                  id_company: getUrlParam("recordId") > 0 ? getUrlParam("recordId") : null,
                }
              }}
              showInModal={true}
              showInModalSimple={true}
              onClose={() => { this.setState({ newDate: "", newTime: "" }) }}
              onSaveCallback={(form: FormActivity<FormActivityProps, FormActivityState>, saveResponse: any) => {
                if (saveResponse.status = "success") this.setState({ newDate: "", newTime: "" })
              }}
            ></FormActivity>
          </ModalSimple>
        }
      </div>
    )
  }
}
