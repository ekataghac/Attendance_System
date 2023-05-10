import { useState, useEffect } from 'react';
import Calendar from 'react-calendar';
import './App.css';

function App() {
  const [date, setDate] = useState(new Date());
  const [holidays, setHolidays] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch('/api/holidays')
      .then(response => response.json())
      .then(data => {
        setHolidays(data);
        setLoading(false);
      })
      .catch(error => console.error(error));
  }, []);

  function tileClassName({ date, view }) {
    if (view === 'month') {
      if (holidays.length === 0) {
        // Return a default class name if holidays array is empty
        return 'noholiday';
      }
      const dayOfWeek = date.getDay();
      if (dayOfWeek === 0 || dayOfWeek === 6) {
        return 'weekend';
      } else if (holidays.some(holiday => {
        const holidayStart = new Date(holiday.start_date);
        const holidayEnd = new Date(holiday.end_date);
        return date >= holidayStart && date <= holidayEnd || date.toDateString() === holidayStart.toDateString();
      })) {
        return 'holiday';
      } else {
        return 'noholiday';
      }
    }
  }


  function tileContent({ date, view }) {
    if (view === 'month') {
      const holiday = holidays.find(holiday => {
        const holidayDate = new Date(holiday.date);
        return date.toDateString() === holidayDate.toDateString();
      });
      return holiday ? <p className="holiday-name">{holiday.name}</p> : null;
    }
  }

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div className="app">
      <div className="calendar-container">
        <h1 className="header">Holiday Calendar</h1>
        <Calendar
          onChange={setDate}
          value={date}
          tileClassName={tileClassName}
          tileContent={tileContent}
        />
      </div>
      <div className="text-center">
        Selected date: {date.toDateString()}
      </div>
    </div>
  );
}

export default App;
