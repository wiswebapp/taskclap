$(document).ready(function () {
	$("#service-calendar").simpleCalendar({
		fixedStartDay: 0, // begin weeks by sunday
		disableEmptyDetails: true,
		events: [
			// generate new event after tomorrow for one hour
			{
				startDate: new Date(new Date().setHours(new Date().getHours() + 24)).toDateString(),
				endDate: new Date(new Date().setHours(new Date().getHours() + 25)).toISOString(),
				summary: 'Service 1'
			},
			// generate new event for yesterday at noon
			{
				startDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 12, 0)).toISOString(),
				endDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 11)).getTime(),
				summary: 'Service 2'
			},
			// generate new event for the last two days
			{
				startDate: new Date(new Date().setHours(new Date().getHours() - 48)).toISOString(),
				endDate: new Date(new Date().setHours(new Date().getHours() - 24)).getTime(),
				summary: 'Service 3'
			}
		],

	});
});