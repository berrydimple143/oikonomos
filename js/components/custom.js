document.addEventListener('alpine:init', () => {
    Alpine.data('dashboardLoad', () => ({
        page: '', 
        chartTitle: "Income & Expense with attendance as of ",        
        loaded: false,
        menuToggle: false,
        stickyMenu: false,                     
        selected: false,
        sidebarToggle: false, 
        scrollTop: false,        
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        income: [0,0,0,0,0,0,0,0,0,0,0,0],
        expense: [40, 10, 43, 18, 16, 30, 33, 27, 43, 36, 21, 48],
        attendance: [30, 30, 30, 25, 20, 25, 25, 40, 32, 34, 25, 28],
        redirectUrl: '../login.php',        
        currentYear: null,
        user_id: null,
        user_email: null,
        user_firstname: null,
        user_lastname: null,
        user_organization: null,        
        incomes: [],        
        date_received: dateTimeNowFormatter('datetime'),        
        received_on: dateTimeNowFormatter('datetime'),
        source: '',
        amount: '',
        received_from: '',        
        incomeId: null,
        description: '',
        inmode: 'add',
        incomeModal: null,
        viewIncomeModal: null,
        incomeAPI: '../api/admin/income.php',
        incomeCounterAPI: '../api/admin/countIncome.php',
        currentPage: 1,
        searchQuery: '',
        pageSize: 7,
        maxVisibleButtons: 5,
        masterChart: null,
        grossNumber: 0,
        // Expenses 
        received_by: '',
        asset: '',
        xdescription: '',
        receipt_number: '',
        expensed_on: dateTimeNowFormatter('datetime'),
        date_expensed: dateTimeNowFormatter('datetime'),
        expenseAPI: '../api/admin/expense.php',
        expenseCounterAPI: '../api/admin/countExpense.php',        
        expenses: [],
        expenseId: null,
        expenseNumber: 0,
        exmode: 'add',
        xcurrentPage: 1,
        xsearchQuery: '',
        xpageSize: 7,
        xmaxVisibleButtons: 5,
        // D3.js Chart - Start
        rawData: [],
        selectedMonth: 'all',
        allLabels: [],
        visibleLabels: [],
        chartDataAPI: '../api/admin/chart.php',
        maxValue: 0,

        async getRawData() {
            try {
                let response = await fetch(this.chartDataAPI, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ 
                        year: this.currentYear,
                        user_id: this.user_id
                    })
                });
                this.rawData = await response.json();
                
                // Extract distinct labels dynamically from JSON
                if (this.rawData.length > 0) {
                    this.maxValue = this.rawData[0].maxValue;
                    this.grossNumber = this.rawData[0].total_income;
                    this.expenseNumber = this.rawData[0].total_expense;
                    this.allLabels = this.rawData[0].metrics.map(m => m.label);
                    this.visibleLabels = [...this.allLabels]; // All visible by default
                }
            } catch (error) {
                console.error("Error loading JSON data:", error);
                return;
            }

            // Watch both filters for automated re-rendering
            this.$watch('selectedMonth', () => this.renderChart());
            this.$watch('visibleLabels', () => this.renderChart());
            this.$watch('rawData', () => this.renderChart());

            this.renderChart();
        },

        async initChart() {
            this.getRawData();
        },

        toggleLabel(label) {
            if (this.visibleLabels.includes(label)) {
                this.visibleLabels = this.visibleLabels.filter(l => l !== label);
            } else {
                this.visibleLabels.push(label);
            }
        },

        getLabelColor(label) {
            const sampleMetrics = this.rawData[0]?.metrics || [];
            const match = sampleMetrics.find(m => m.label === label);
            return match ? match.colorStart : '#fff';
        },

        renderChart() {
            const container = this.$refs.canvas;
            container.innerHTML = '';

            // Skip render if no labels selected
            if (this.visibleLabels.length === 0) return;

            // 1. Filter dataset by month selection & visible labels
            const dataToRender = (this.selectedMonth === 'all' 
                ? this.rawData 
                : this.rawData.filter(d => d.month === this.selectedMonth)
            ).map(monthItem => ({
                month: monthItem.month,
                metrics: monthItem.metrics.filter(m => this.visibleLabels.includes(m.label))
            }));

            const margin = { top: 1, right: 20, bottom: 30, left: 50 };
            const width = 750 - margin.left - margin.right;
            const height = 380 - margin.top - margin.bottom;

            const svg = d3.select(container)
                .append('svg')            
                .attr('viewBox', `0 0 ${width + margin.left + margin.right} ${height + margin.top - 10 + margin.bottom}`)
                //.attr('height', 400)
                .append('g')
                .attr('transform', `translate(${margin.left},${margin.top})`);

            // Color Gradients Setup
            const defs = svg.append('defs');
            const sampleMetrics = this.rawData[0]?.metrics || [];
            sampleMetrics.forEach((d, i) => {
                const gradient = defs.append('linearGradient')
                .attr('id', `gradient-${d.label.replace(/\s+/g, '-')}`)
                .attr('x1', '0%').attr('y1', '0%')
                .attr('x2', '0%').attr('y2', '100%');

                gradient.append('stop').attr('offset', '0%').attr('stop-color', d.colorStart);
                gradient.append('stop').attr('offset', '100%').attr('stop-color', d.colorEnd);
            });

            // Outer Scale (Months)
            const x0 = d3.scaleBand()
                .domain(dataToRender.map(d => d.month))
                .range([0, width])
                .paddingInner(0.25);

            // Inner Scale (Only Active Visible Labels)
            const x1 = d3.scaleBand()
                .domain(this.visibleLabels)
                .range([0, x0.bandwidth()])
                .padding(0.1);

            // Dynamic Y Scale based ONLY on currently visible bars
            // const maxVal = d3.max(dataToRender, d => d3.max(d.metrics, m => m.value)) || 1000;              
            const y = d3.scaleLinear()
                //.domain([0, d3.max(d.metrics, d => d.value)])
                .domain([0, this.maxValue * 1.15])
                .range([height, 0]);

            // Header Text
            svg.append('text')                
                .attr('y', 12)
                .attr('x', 10)
                .attr('text-anchor', 'start')
                .attr('class', 'fill-gray-100 text-[12px] font-semibold tracking-tighter')
                .text("Income & Expenses with Attendance as of " + this.currentYear);
            
            // Gross, Expense and Net Text
            const computations = "Gross Income: " + currencyFormatter(this.grossNumber, 'PHP') + " | " + "Expenses: " + currencyFormatter(this.expenseNumber, 'PHP') + " | Net Income: " + currencyFormatter((this.grossNumber - this.expenseNumber), 'PHP');
            
            svg.append('text')
                .attr('y', 12)
                .attr('x', width / 2)
                .attr('text-anchor', 'start')
                .attr('class', 'fill-gray-100 text-[10px] font-semibold tracking-normal')
                .text(computations);                        

            // X-Axis
            svg.append('g')
                .attr('transform', `translate(0,${height})`)
                .call(d3.axisBottom(x0).tickSize(0))
                .selectAll('text')
                .attr('class', 'fill-gray-100 text-xs font-medium')
                .attr('dy', '10');

            // Y-Axis Gridlines
            svg.append('g')
                .attr('class', 'grid')
                .call(d3.axisLeft(y).ticks(5).tickSize(-width).tickFormat(''))
                .selectAll('line')
                .attr('stroke', '#898888')
                .attr('stroke-dasharray', '4,4');

            // Y-Axis Values (White Text)
            const yAxis = d3.axisLeft(y)
                .ticks(5)
                .tickFormat(d3.format('~s'));
                
            const yAxisGroup = svg.append('g').call(yAxis);
            yAxisGroup.select('.domain').remove();
            yAxisGroup.selectAll('text')
                .attr('class', 'fill-gray-100 text-xs font-mono font-semibold')
                .attr('dx', '-6');

            // Y-Axis Label Title
            svg.append('text')
                .attr('transform', 'rotate(-90)')
                .attr('y', -margin.left + 18)
                .attr('x', -height / 2)
                .attr('text-anchor', 'middle')
                .attr('class', 'fill-gray-100 text-[10px] font-semibold uppercase tracking-wider');
                //.text('Value as per currency');

            const tooltip = d3.select(this.$refs.tooltip);

            // Bars Group
            const monthGroups = svg.append('g')
                .selectAll('g')
                .data(dataToRender)
                .enter()
                .append('g')
                .attr('transform', d => `translate(${x0(d.month)},0)`);

            // Rectangular Bars
            monthGroups.selectAll('rect')
                .data(d => d.metrics.map(m => ({ ...m, month: d.month })))
                .enter()
                .append('rect')
                .attr('x', d => x1(d.label))
                .attr('width', x1.bandwidth())
                .attr('rx', 4)
                .attr('fill', d => `url(#gradient-${d.label.replace(/\s+/g, '-')})`)
                .attr('y', height)
                .attr('height', 0)
                .attr('class', 'transition-opacity duration-150 hover:opacity-60 cursor-pointer')
                .on("click", function(event, d) {
                    // 'event' is the native DOM event object
                    // 'd' is the specific data object tied to the clicked bar
                    
                    console.log("You clicked the bar for:", d.label);
                    console.log("The associated value is:", d.value);
                    
                    // Example action: trigger an alert or a dynamic update
                    alert(`Clicked ${d.label} with a value of ${d.value}`);
                })
                .on('mouseover', (event, d) => {
                    tooltip
                    .style('opacity', '1')
                    .html(`
                        <div class="font-bold text-slate-100 mb-1 border-b border-slate-100 pb-0.5">${d.month}</div>
                        <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full" style="background-color: ${d.colorStart}"></span>
                        <span class="text-slate-100">${d.label}:</span>
                        <span class="font-mono font-semibold text-white">${currencyFormatterWithChecking(d.value, 'PHP', d.label)}</span>
                        </div>
                    `)
                    .style('left', `${event.offsetX + 12}px`)
                    .style('top', `${event.offsetY - 35}px`);
                })
                .on('mousemove', (event) => {
                    tooltip
                    .style('left', `${event.offsetX - 100}px`)
                    .style('top', `${event.offsetY - 65}px`);
                })
                .on('mouseout', () => tooltip.style('opacity', '0'))
                .transition()
                .duration(600)
                .ease(d3.easeCubicOut)
                .attr('y', d => y(d.value))
                .attr('height', d => height - y(d.value));                

            // Top of Bar Values
            monthGroups.selectAll('.bar-value')
                .data(d => d.metrics)
                .enter()
                .append('text')
                .attr('class', 'bar-value fill-yellow-400 text-[10px] font-mono font-semibold')
                .attr('x', d => x1(d.label) + x1.bandwidth() / 2)
                .attr('y', height)
                .attr('text-anchor', 'middle')
                .text(d => d3.format('~s')(d.value))
                //.text(d => currencyFormatter(d.value, 'PHP'))
                .transition()
                .duration(600)
                .ease(d3.easeCubicOut)
                .attr('y', d => y(d.value) - 6);
        },
        // D3.js Chart - End

        // async getIncomes() {
        //     let response = await fetch(this.incomeCounterAPI, {
        //             method: 'POST',
        //             headers: {'Content-Type': 'application/json'},
        //             body: JSON.stringify({ 
        //                 year: '2026'
        //             })
        //         });
        //     const reg = await response.json();	
        //     this.income[0] = reg.janIncome === 0 ? null : reg.janIncome;
        //     this.income[1] = reg.febIncome === 0 ? null : reg.febIncome;
        //     this.income[2] = reg.marIncome === 0 ? null : reg.marIncome;
        //     this.income[3] = reg.aprIncome === 0 ? null : reg.aprIncome;
        //     this.income[4] = reg.mayIncome === 0 ? null : reg.mayIncome;
        //     this.income[5] = reg.junIncome === 0 ? null : reg.junIncome;
        //     this.income[6] = reg.julIncome === 0 ? null : reg.julIncome;
        //     this.income[7] = reg.augIncome === 0 ? null : reg.augIncome;
        //     this.income[8] = reg.sepIncome === 0 ? null : reg.sepIncome;
        //     this.income[9] = reg.octIncome === 0 ? null : reg.octIncome;
        //     this.income[10] = reg.novIncome === 0 ? null : reg.novIncome;
        //     this.income[11] = reg.decIncome === 0 ? null : reg.decIncome;
        //     this.grossNumber = reg.total;                
        // },        

        // async getExpenses() {
        //     let response = await fetch(this.expenseCounterAPI, {
        //                 method: 'POST',
        //                 headers: {'Content-Type': 'application/json'},
        //                 body: JSON.stringify({ 
        //                     year: '2026'
        //                 })
        //             });
        //         const reg = await response.json();	
        //         this.expense[0] = reg.janExpense === 0 ? null : reg.janExpense;
        //         this.expense[1] = reg.febExpense === 0 ? null : reg.febExpense;
        //         this.expense[2] = reg.marExpense === 0 ? null : reg.marExpense;
        //         this.expense[3] = reg.aprExpense === 0 ? null : reg.aprExpense;
        //         this.expense[4] = reg.mayExpense === 0 ? null : reg.mayExpense;
        //         this.expense[5] = reg.junExpense === 0 ? null : reg.junExpense;
        //         this.expense[6] = reg.julExpense === 0 ? null : reg.julExpense;
        //         this.expense[7] = reg.augExpense === 0 ? null : reg.augExpense;
        //         this.expense[8] = reg.sepExpense === 0 ? null : reg.sepExpense;
        //         this.expense[9] = reg.octExpense === 0 ? null : reg.octExpense;
        //         this.expense[10] = reg.novExpense === 0 ? null : reg.novExpense;
        //         this.expense[11] = reg.decExpense === 0 ? null : reg.decExpense;
        //         this.expenseNumber = reg.total;
        // },

        async initExpenses() {
            this.inmode = 'add';
            try {
                let response = await fetch(this.expenseAPI, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ 
                        id: 2,
                        status: 1,
                        user_id: this.user_id,
                        asset: 'sample',
                        amount: 'sample',
                        received_by: 'sample',
                        receipt_number: 'sample',
                        description: 'sample',
                        date_expensed: 'sample',
                        mode: "getAll"
                    })
                });
                let exp = await response.json();
                this.expenses = exp.data;   
            } catch(error) {
                console.error('Error fetching data:', error);
            }
        },  

        async initIncomes() {
            this.inmode = 'add';
            try {
                let response = await fetch(this.incomeAPI, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ 
                        id: 2,
                        status: 1,
                        user_id: this.user_id,
                        source: 'sample',
                        amount: 'sample',
                        received_from: 'sample',
                        description: 'sample',
                        date_received: 'sample',
                        mode: "getAll"
                    })
                });
                let inc = await response.json();
                this.incomes = inc.data;       
            } catch(error) {
                console.error('Error fetching data:', error);
            }
        },  

        deleteIncomeConfirm(id) {
            const decision = confirm("Are you sure you want to delete this income?");
            if(decision) {
                this.deleteIncome(id);
            }
        },

        deleteExpenseConfirm(id) {
            const decision = confirm("Are you sure you want to delete this expense?");
            if(decision) {
                this.deleteExpense(id);
            }
        },

        async deleteExpense(id) {
            try {
                let response = await fetch(this.expenseAPI, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ 
                        id: id,
                        status: 1,
                        user_id: this.user_id,
                        asset: 'sample',
                        amount: 'sample',
                        received_by: 'sample',
                        description: 'sample',
                        date_expensed: 'sample',
                        mode: "delete"
                    })
                });
                let info = await response.json();
                this.expenses = info.data;
            } catch(error) {
                console.error('Error fetching data:', error);
            }
        },

        async deleteIncome(id) {
            try {
                let response = await fetch(this.incomeAPI, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ 
                        id: id,
                        status: 1,
                        user_id: this.user_id,
                        source: 'sample',
                        amount: 'sample',
                        received_from: 'sample',
                        description: 'sample',
                        date_received: 'sample',
                        mode: "delete"
                    })
                });
                let info = await response.json();
                this.incomes = info.data;
            } catch(error) {
                console.error('Error fetching data:', error);
            } 
        },   

        editIncome(info) {
            this.inmode = 'edit';
            this.source = info.source;
            this.amount = info.amount;
            this.user_id = info.user_id;
            this.received_from = info.received_from;
            this.date_received = info.date_received;
            this.description = info.description;
            this.incomeId = info.id;
            this.navigate('income_form');
        },

        editExpense(info) {
            this.exmode = 'edit';
            this.asset = info.asset;
            this.amount = info.amount;
            this.user_id = info.user_id;
            this.received_by = info.received_by;
            this.date_expensed = info.date_expensed;
            this.receipt_number = info.receipt_number;
            this.xdescription = info.description;
            this.expenseId = info.id;
            this.navigate('expense_form');
        },

        viewIncome(info) {
            this.source = info.source;
            this.amount = currencyFormatter(info.amount, 'PHP');
            this.user_id = info.user_id;
            this.received_from = info.received_from;
            this.date_received = info.date_received;
            this.received_on = info.received_on;
            this.description = info.description;
            this.incomeId = info.id;
            this.viewIncomeModal.classList.remove('hidden');
        },

        closeIncomeDetails() {
            this.clearForm();
            this.viewIncomeModal.classList.add('hidden');
        },

        viewExpense(info) {
            this.asset = info.asset;
            this.amount = currencyFormatter(info.amount, 'PHP');
            this.user_id = info.user_id;
            this.received_by = info.received_by;
            this.date_expensed = info.date_expensed;
            this.receipt_number = info.receipt_number;
            this.expensed_on = info.expensed_on;
            this.description = info.description;
            this.expenseId = info.id;
            this.viewExpenseModal.classList.remove('hidden');
        },

        closeExpenseDetails() {
            this.clearForm();
            this.viewExpenseModal.classList.add('hidden');
        },       

        async submitExpense() {
            let id = 2;
            if(this.exmode == 'edit') { id = this.expenseId; }
                try {
                    this.expenseModal.classList.remove('hidden');
                    let response = await fetch(this.expenseAPI, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({ 
                            id: id,
                            status: 1,
                            user_id: this.user_id,
                            asset: this.asset,
                            amount: this.amount,
                            receipt_number: this.receipt_number,
                            received_by: this.received_by,
                            description: this.xdescription,
                            date_expensed: this.date_expensed,
                            mode: this.exmode
                        })
                    });
                    let info = await response.json();
                    this.expenses = info.data;
                } catch(error) {
                    console.error('Error fetching data:', error);
                } finally {          
                    //this.getExpenses();                    
                    setTimeout(() => {                        
                        this.navigate('expense');
                        this.clearForm();
                        this.expenseModal.classList.add('hidden');
                        // this.masterChart.data.datasets[0].data = this.expense;
                        // this.masterChart.update();
                    }, 1000);
                }
        },

        async submitIncome() {
            let id = 2;
            if(this.inmode == 'edit') { id = this.incomeId; }
                try {
                    this.incomeModal.classList.remove('hidden');
                    let response = await fetch(this.incomeAPI, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({ 
                            id: id,
                            status: 1,
                            user_id: this.user_id,
                            source: this.source,
                            amount: this.amount,
                            received_from: this.received_from,
                            description: this.description,
                            date_received: this.date_received,
                            mode: this.inmode
                        })
                    });
                    let info = await response.json();
                    this.incomes = info.data;
                } catch(error) {
                    console.error('Error fetching data:', error);
                } finally {          
                    //this.getIncomes();                           
                    setTimeout(() => {                        
                        this.navigate('income');
                        this.clearForm();
                        this.incomeModal.classList.add('hidden');                        
                        // this.masterChart.data.datasets[0].data = this.income;
                        // this.masterChart.update();
                    }, 1000);
                }
        },
        navigate(pg) {
            this.getRawData();
            if(pg === "income") {
                // For income info
            } else if(pg === "income_form") {
                // For expenses info                
            } else if(pg === "expense") {
                // For expenses info
            } else if(pg === "expense_form") {
                // For expenses info
            } else if(pg === "attendance") {
                // For attendance info
            } else if(pg === "projection") {
                // For projection info
            }            
            let url = "../admin/" + pg;
            window.history.replaceState({}, '', url);                       
            this.page = pg;
        },
        checkAuth() {
            let logged = sessionStorage.getItem("logged");
            this.user_id = sessionStorage.getItem("user_id");
            this.user_email = sessionStorage.getItem("email");
            this.user_firstname = sessionStorage.getItem("firstname");
            this.user_lastname = sessionStorage.getItem("lastname");
            this.user_organization = sessionStorage.getItem("organization");
            
            setTimeout(() => {
                if(!logged) {
                    window.location = this.redirectUrl;
                } 
            }, 50);
        },
        initModals() {
            this.incomeModal = document.getElementById('incomeModal');
            this.expenseModal = document.getElementById('expenseModal');
            this.viewIncomeModal = document.getElementById('viewIncomeModal');
            this.viewExpenseModal = document.getElementById('viewExpenseModal');                   
        },
        // initChart() {
        //     let grossIncome = this.grossNumber;
        //     let expenses = this.expenseNumber;
        //     let netIncome = grossIncome - expenses;

        //     const staticLabelPlugin = {
        //         id: 'staticLabel',
        //         afterDraw(chart) {
        //             const { ctx, chartArea: { top, left, width, height } } = chart;
        //             ctx.save();
                    
        //             ctx.font = 'bold 12px Arial';
        //             ctx.fillStyle = '#fff';
        //             ctx.textAlign = 'center';
        //             ctx.textBaseline = 'middle';
                    
        //             const x = left + width - 150;
        //             const y = top - 60;
        //             const totalX = x + 90;
        //             const lineX = x + 43;
        //             const labelX = x - 20;
                    
        //             ctx.fillText('Gross Income : ', labelX, y);
        //             ctx.fillText(currencyFormatter(grossIncome, 'PHP'), totalX, y);
        //             ctx.fillText('Expenses        : ', labelX, y + 15);   
        //             ctx.fillText("- " + currencyFormatter(expenses, 'PHP'), totalX - 4, y + 15);    
        //             ctx.fillText("_________________________________", lineX, y + 19);
        //             ctx.fillText('Net Income      : ', labelX, y + 35);
        //             ctx.fillText(currencyFormatter(netIncome, 'PHP'), totalX, y + 35);

        //             ctx.strokeStyle = "#fff";
        //             ctx.lineWidth = 1;
        //             ctx.strokeRect(x - 70, y - 18, 223, 65);
        //             ctx.restore();
        //         }
        //     };

        //     this.masterChart = Alpine.raw(new Chart(this.$refs.graphCanvas, {
        //         type: 'bar',
        //         data: {
        //             labels: this.labels,
        //             datasets: [
        //                 {
        //                     label: 'Income',
        //                     data: this.income,					
        //                     borderWidth: 1,
        //                     minBarLength: 6,
        //                     skipNull: true,                                        
        //                     backgroundColor: '#20f020',
        //                     borderColor: '#117D11'
        //                     // backgroundColor: [
        //                     //     'rgba(255, 99, 132, 0.2)',
        //                     //     'rgba(54, 162, 235, 0.2)',
        //                     //     'rgba(255, 206, 86, 0.2)',
        //                     //     'rgba(75, 192, 192, 0.2)',
        //                     //     'rgba(153, 102, 255, 0.2)',
        //                     //     'rgba(255, 159, 64, 0.2)'
        //                     // ],
        //                     // backgroundColor: function(context) {
        //                     //     const chart = context.chart;
        //                     //     const { ctx, chartArea } = chart;
        //                     //     if (!chartArea) {
        //                     //         return null;
        //                     //     }
        //                     //     const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
        //                     //     gradient.addColorStop(0, 'rgb(158, 247, 170)');
        //                     //     gradient.addColorStop(1, 'rgba(71, 241, 147, 0.2)');
        //                     //     return gradient;
        //                     // }
        //                 },
        //                 {
        //                     label: 'Expenses',
        //                     data: this.expense,
        //                     borderWidth: 1,
        //                     minBarLength: 6,
        //                     skipNull: true,
        //                     borderColor: '#8A0F13', 
        //                     backgroundColor: '#ff0e0e',
        //                 },
        //                 {
        //                     label: 'Attendance',
        //                     data: this.attendance,
        //                     borderWidth: 1,
        //                     minBarLength: 6,
        //                     skipNull: true,
        //                     borderColor: '#240a9a', 
        //                     backgroundColor: '#0cb5e9',
        //                 }
        //             ]
        //         },
        //         plugins: [ChartDataLabels, staticLabelPlugin, {
        //             id: 'customCanvasBackgroundColor',
        //             beforeDraw: (chart) => {
        //                 const { ctx, canvas } = chart;
                        
        //                 ctx.save();
                        
        //                 // Create a vertical gradient matching the full canvas height
        //                 // Parameters: (startX, startY, endX, endY)
        //                 const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
                        
        //                 // Define your color stops (0 is top, 1 is bottom)
        //                 // gradient.addColorStop(0, '#858587'); // Deep blue at the top
        //                 // gradient.addColorStop(0.5, '#a7a5a5'); // Red in the middle
        //                 // gradient.addColorStop(1, '#ecebe8'); // Yellow at the bottom
                        
        //                 gradient.addColorStop(0, '#0F172A'); // Deep blue at the top
        //                 gradient.addColorStop(0.5, '#334155'); // Red in the middle
        //                 gradient.addColorStop(1, '#1E293B'); // Yellow at the bottom
        //                 // Apply gradient to the canvas context and draw the rectangle
        //                 ctx.fillStyle = gradient;
        //                 ctx.fillRect(0, 0, canvas.width, canvas.height);
                        
        //                 ctx.restore();
        //             }
        //         }],
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: true,                    
        //             layout: {
        //                 padding: 10
        //             },
        //             animation: {
        //                 duration: 2000,
        //                 easing: 'easeOutCubic',
        //                 delay: (context) => {
        //                     return context.dataIndex * 100; 
        //                 }
        //                 // easing: 'easeOutQuart',   // Easing function to make the grow effect smoother
        //                 // delay: (context) => {     // Optional: Delays bars so they pop up one by one
        //                 //     let delay = 0;
        //                 //     if (context.type === 'data' && context.mode === 'default') {
        //                 //         delay = context.dataIndex * 150; // 150ms delay per bar
        //                 //     }
        //                 //     return delay;
        //                 // }
        //             },
        //             plugins: {                                    
        //                 datalabels: {
        //                     display: function(context) {
        //                         const value = context.dataset.data[context.dataIndex];
        //                         return value !== null && value !== 0; 
        //                     },
        //                     textShadowColor: 'rgb(36, 32, 32)',
        //                     textShadowBlur: 4,
        //                     textStrokeWidth: 0,
        //                     align: 'end',
        //                     anchor: 'end',
        //                     color: '#fff',
        //                     font: {
        //                         weight: 'bold',
        //                         size: 14
        //                     },
        //                     formatter: function(value, context) {
        //                         if(context.dataset.label != "Attendance") {
        //                             return currencyFormatter(value, 'PHP');
        //                         } else {
        //                             return value;
        //                         }                                            
        //                     }
        //                 },		
        //                 title: {
        //                     display: true,
        //                     text: this.chartTitle + this.currentYear,
        //                     color: '#fff',
        //                     font: { size: 18 }
        //                 },					
        //                 legend: {
        //                     labels: {	
        //                         color: '#fff',			
        //                         font: { size: 16 }
        //                     }
        //                 },
        //                 tooltip: {
        //                     titleColor: '#fff', 
        //                     bodyColor: '#fff'
        //                 }
        //             },
        //             scales: {
        //                 x: {
        //                     ticks: { 
        //                         color: '#fff', 
        //                         font: { size: 15 } 
        //                     },
                            
        //                 },
        //                 y: {
        //                     ticks: { 
        //                         color: '#fff',
        //                         font: { size: 15 }
        //                     },
        //                     beginAtZero: true,
        //                     max: this.getMaxNumber()
        //                 }
        //             }
        //         }                                  
        //     }));
        // },        

        getMaxNumber() {
            const incm = Math.max(...this.income);
            const expn = Math.max(...this.expense);
            if(incm >= expn) {
                return incm + 50;
            } else {
                return expn + 50;
            }
        },
        init() {
            this.checkAuth();
            const currentDate = new Date();
            this.currentYear = currentDate.getFullYear();
            this.initIncomes();
            this.initExpenses();
            this.initModals();
            //this.getIncomes();
            //this.getExpenses();            
            this.initChart();            
        },
        clearForm() {
            this.source = "";
            this.amount = "";
            this.received_from = "";            
            this.description = "";            
            this.received_by = "";     
            this.asset = "";     
            this.date_received = dateTimeNowFormatter('datetime');
            this.date_expensed = dateTimeNowFormatter('datetime');
        },

        get totalPages() {
            return Math.ceil(this.filteredItems.length / this.pageSize);
        },
        get paginatedItems() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.filteredItems.slice(start, end);
        },
        get filteredItems() {
            return this.incomes.filter(item => item.source.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.amount.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.description.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.received_from.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.received_on.toLowerCase().includes(this.searchQuery.toLowerCase()));            
        },
        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        goToPage(page) {
            this.currentPage = page;
        },
        get visiblePages() {
            let start = Math.max(1, this.currentPage - Math.floor(this.maxVisibleButtons / 2));
            let end = start + this.maxVisibleButtons - 1;

            if (end > this.totalPages) {
                end = this.totalPages;
                start = Math.max(1, end - this.maxVisibleButtons + 1);
            }

            const pages = [];
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },

        // For Expenses

        get xtotalPages() {
            return Math.ceil(this.xfilteredItems.length / this.xpageSize);
        },
        get xpaginatedItems() {
            const start = (this.xcurrentPage - 1) * this.xpageSize;
            const end = start + this.xpageSize;
            return this.xfilteredItems.slice(start, end);
        },
        get xfilteredItems() {
            return this.expenses.filter(item => item.asset.toLowerCase().includes(this.xsearchQuery.toLowerCase()) || item.amount.toLowerCase().includes(this.xsearchQuery.toLowerCase()) || item.description.toLowerCase().includes(this.xsearchQuery.toLowerCase()) || item.received_by.toLowerCase().includes(this.xsearchQuery.toLowerCase()) || item.expensed_on.toLowerCase().includes(this.xsearchQuery.toLowerCase()));            
        },
        nextPage() {
            if (this.xcurrentPage < this.xtotalPages) this.xcurrentPage++;
        },
        prevPage() {
            if (this.xcurrentPage > 1) this.xcurrentPage--;
        },
        goToPage(page) {
            this.xcurrentPage = page;
        },
        get xvisiblePages() {
            let start = Math.max(1, this.xcurrentPage - Math.floor(this.xmaxVisibleButtons / 2));
            let end = start + this.xmaxVisibleButtons - 1;

            if (end > this.xtotalPages) {
                end = this.xtotalPages;
                start = Math.max(1, end - this.xmaxVisibleButtons + 1);
            }

            const pages = [];
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },
        
        logout() {
            sessionStorage.clear();
            window.location = this.redirectUrl;
        }
    }));
});
