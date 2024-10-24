<template>
	<div class="container my-5">
		<div class="row">
	      <div class="col-lg-4 col-xl-3 shadow-sm rounded-4 bg-custom p-4">
		  <aside class="gloss-sidebar" id="gloss-sidebar">
		    <h3>Table of Contents</h3>
		    <div class="accordion">
		      <div
		        class="accordion-item"
		        v-for="(item, index) in accordionItems"
		        :key="index"
		      >
		        <button
		          class="accordion-button"
		          :class="{ active: activeIndex === index }"
		          @click="toggleAccordion(index)"
		          :aria-expanded="activeIndex === index"
		          :aria-controls="`collapse${index}`"
		        >
		          {{ item.title }}
		        </button>
		        <div
		          class="accordion-collapse"
		          v-show="activeIndex === index"
		          :id="`collapse${index}`"
		          :aria-labelledby="`heading${index}`"
		        >
		          <div class="accordion-body">
		            <ul>
		              <li v-for="(link, linkIndex) in item.links" :key="linkIndex">
		                <a :href="link.href">{{ link.text }}</a>
		              </li>
		            </ul>
		          </div>
		        </div>
		      </div>
		    </div>
		  </aside>

	      </div>
	      <div class="col-lg-8 col-xl-9 shadow-sm rounded-4 p-3 px-lg-5">
	        <div class="glossary-content pb-5">
	          <h2 class="text-left">Understanding Risk</h2>
	          <div class="border-heading"></div>
	          <div class="understanding pt-3" id="assessing">
	            <h3>Assessing Your Risk Tolerance</h3>
	            <p>Assessing your risk tolerance is a crucial step in the investment process. It involves evaluating your
	              comfort level with different levels of financial risk based on your investment goals and time horizon.
	              Your
	              risk tolerance can significantly impact your investment decisions, and here's why:</p>
	            <p><b>Investment Goals:</b> Your risk tolerance is closely tied to your investment objectives. Whether
	              you're
	              saving for a short-term goal or planning for a long-term retirement, understanding your risk tolerance
	              helps
	              align your investments with your goals.</p>
	            <p><b>Time Horizon:</b> Consider how much time you have before needing access to your invested funds. If you
	              have a longer time horizon, you may be more willing to take on higher-risk investments, as you have time
	              to
	              recover from potential losses.</p>
	            <p><b>Risk Capacity: </b>Assess your financial situation, including income, expenses, debts, and emergency
	              savings. A robust financial foundation can provide you with a higher risk capacity, allowing you to
	              consider
	              more aggressive investment strategies.</p>
	            <p><b>Risk Appetite: </b>Your emotional comfort with risk plays a significant role. Some investors are
	              naturally more risk-averse, preferring conservative investments, while others are comfortable with higher
	              levels of risk and potential volatility.</p>
	            <p><b>Diversification:</b> Diversifying your portfolio, or spreading your investments across various asset
	              classes, can help manage risk. Your risk tolerance will influence how aggressively you diversify your
	              holdings.</p>
	            <p><b> Regular Review:</b> Your risk tolerance is not static; it can change over time due to changes in
	              financial circumstances or life goals. It's essential to revisit and reassess your risk tolerance
	              periodically.</p>
	            <p><b>Consultation:</b> If you're unsure about your risk tolerance or how it should inform your investment
	              choices, consider consulting with a financial advisor. They can help you assess your risk tolerance and
	              develop an investment strategy that aligns with your unique circumstances.</p>
	          </div>
	          <div class="balancing pt-3" id="Balancing">
	            <h3>Balancing Risk and Reward</h3>
	            <p><b>Risk Assessment:</b> Acknowledge that investments carry inherent risks. It's possible to experience
	              losses, and there's a chance you may receive back less than your initial investment. Only invest funds you
	              can
	              afford to potentially lose without jeopardizing your financial well-being.</p>

	            <p><b>Risk-Reward Relationship:</b> Basic economic principles state that higher-risk investments typically
	              offer
	              the potential for higher returns. However, assessing and managing risk is critical to achieving a
	              favorable
	              risk-reward balance.</p>

	            <p><b>Measuring Risk:</b> Risk can be quantified by calculating the volatility of an investment or
	              portfolio.
	              Volatility measures the extent to which an asset's value deviates from its average. Greater variation
	              indicates higher risk.</p>

	            <p><b>Correlation Matters:</b> Consider the correlation between different investments. Positive correlation
	              implies that two assets tend to move in the same direction, while negative correlation means they move in
	              opposite directions. Diversifying with assets that have low or negative correlation can reduce overall
	              portfolio risk.</p>

	            <p><b>Diversification:</b> Diversification is a key risk mitigation strategy. By spreading your investments
	              across various assets, sectors, regions, or instruments, you can reduce exposure to the risk of any single
	              holding. This helps break down risk and improve overall portfolio stability.</p>

	            <p><b>Stocks vs. Bonds:</b> Bonds issued by stable governments with high credit ratings are generally
	              considered
	              lower risk compared to stocks. However, it's essential to recognize that market conditions and the
	              characteristics of specific bonds can influence risk. High-yield corporate bonds, for example, may exhibit
	              equity-like risk behavior.</p>

	            <p><b>Individual Evaluation:</b> Assess each investment individually, considering its unique characteristics
	              and
	              risk profile. Not all bonds are less risky than stocks, and the particular attributes of an investment can
	              override general rules of thumb.</p>
	          </div>

	          <div class="investors pt-3" id="Investor">
	            <h3>Investor Profiles and Their Risk Preferences</h3>
	            <p><b>Young Professionals:</b> Individuals in their early 20s, just starting their careers, often have a
	              long
	              investment horizon. They are more inclined to accept higher levels of short-term risk, as they have time
	              to
	              recover from potential losses and capitalize on long-term growth opportunities. Their primary focus may be
	              wealth accumulation.</p>

	            <p><b>Retirees:</b> Pensioners and older investors, in contrast, tend to be more risk-averse. They've
	              accumulated their lifetime wealth and may prioritize funding their retirement or distributing assets among
	              family members. Their investment strategy may lean towards income generation and capital preservation.</p>

	            <p><b>Income-Oriented Investors:</b> Some investors seek to generate a consistent stream of income.
	              Risk-averse retirees, for instance, may prefer low-risk bonds with longer maturities to achieve passive
	              income over time. They prioritize stability and predictable cash flow.</p>

	            <p><b>Growth-Oriented Investors:</b> Those aiming to build substantial wealth over the long term may accept
	              a
	              higher level of risk. They may allocate a significant portion of their investments to higher
	              dividend-yield
	              stocks, venture into growth stocks, or explore riskier assets to maximize returns.</p>

	            <p><b>Ethical and ESG Investors:</b> Investors with strong ethical and Environmental, Social, and Governance
	              (ESG) preferences prioritize aligning their investments with their values. They may choose investments
	              that
	              promote sustainability and responsible business practices, even if it means deviating from conventional
	              risk-reward profiles.</p>

	            <p><b>Income and Growth Blends:</b> Some investors strike a balance between income and growth. They seek
	              investments that offer both steady income and potential for capital appreciation. Balanced portfolios may
	              include a mix of dividend stocks, bonds, and other assets.</p>

	            <p><b>Passive and Active Investors:</b> Investors can opt for passive strategies, like index funds or
	              Exchange-Traded Funds (ETFs), or active management through stock picking and frequent portfolio
	              adjustments.
	              Risk preferences can influence this choice.</p>
	          </div>


	          <div class="contrasting pt-3" id="Contrasting">
	            <h3>Contrasting Passive and Active Investment Strategies</h3>
	            <p>Investors have two primary approaches when it comes to managing their portfolios: passive and active
	              investment strategies. These strategies differ significantly in their approach, objectives, and level of
	              involvement. Here's a breakdown of the key distinctions:
	            </p>
	            <h4>Passive Investing</h4>
	            <p><b>Approach:</b> Passive investing aims to replicate the performance of a specific market index, such as
	              the S&amp;P 500 or a bond index. It involves minimal active decision-making to deviate from the market's
	              performance.</p>

	            <p><b>Investment Vehicles:</b> Passive investors commonly use Exchange-Traded Funds (ETFs) or index funds.
	              These funds hold a similar composition of assets to the underlying index and periodically adjust their
	              holdings to reflect changes in the index.</p>

	            <p><b>Management:</b> Passive investing involves fewer active decisions by fund managers. Trades are
	              typically
	              infrequent and are made to maintain alignment with the index, not to outperform it.</p>

	            <p><b>Long-Term Focus:</b> Passive investors usually adopt a long-term buy-and-hold strategy. They hold
	              their
	              investments for extended periods, often years or decades, to capture the long-term growth of the overall
	              market.</p>

	            <h4>Active Investing</h4>

	            <p><b>Approach:</b> Active investing takes a proactive approach to portfolio management. Investors actively
	              monitor their positions, make buy or sell decisions, and adjust their holdings based on their market views
	              and analysis.</p>

	            <p><b>Flexibility:</b> Active investors have greater flexibility in determining the weight or allocation of
	              individual holdings in their portfolio. Unlike passive investors, who aim to mirror a market index, active
	              investors can adjust exposure levels according to their strategies.</p>

	            <p><b>Investment Universe:</b> Active investors can invest in assets that are not part of the benchmark
	              index
	              they are tracking. This flexibility allows them to explore opportunities beyond the index constituents.
	            </p>

	            <p><b>Analysis and Rebalancing:</b> Active investing requires in-depth analysis to identify optimal entry
	              and
	              exit points for financial instruments. It often involves frequent portfolio re-balancing to capitalize on
	              short-term opportunities.</p>
	          </div>
	        </div>
	        <div class="glossary-content pb-5">
	          <h2 class="text-left">Exploring Investment Strategies</h2>
	          <div class="border-heading"></div>
	          <div class="understanding pt-3" id="fundamental">
	            <h3>Fundamental Analysis vs. Technical Analysis</h3>
	            <p>When it comes to analyzing financial markets, investors and traders have two primary approaches at their
	              disposal: fundamental analysis and technical analysis. These methods are distinct in their methodologies
	              and objectives, each offering a unique perspective on market opportunities:</p>
	            <h4>Fundamental Analysis</h4>
	            <p><b>Objective: </b> Fundamental analysis aims to determine the intrinsic value of a financial asset, such
	              as a stock or a company. It seeks to identify whether an asset is undervalued or overvalued based on its
	              underlying economic and financial factors.</p>
	            <p><b>Key Factors: </b>Fundamental analysis examines a wide range of factors, including a company's
	              financial statements (income statement, balance sheet, cash flow statement), earnings growth potential,
	              competitive position in the industry, management quality, economic conditions, and more.</p>
	            <p><b>Valuation Methods: </b> Two common methods used in fundamental analysis are cash flow analysis and
	              multiples analysis. Cash flow analysis forecasts the expected cash generation of an investment over time,
	              while multiples analysis compares financial ratios (e.g., price-to-earnings ratio) to those of peer
	              companies.</p>

	            <p><b>Intrinsic Value: </b>Fundamental analysis attempts to determine the intrinsic or fair value of an
	              asset, representing what it should be worth under current market conditions.</p>
	            <h4>Technical Analysis</h4>
	            <p><b>Objective: </b> Technical analysis focuses on predicting future market prices and trends based on
	              historical price and volume data. It doesn't seek to determine an asset's intrinsic value but rather where
	              its prices are likely to move in the future.</p>
	            <p><b>Key Tools: </b>Technical analysts use various tools, including charts, technical indicators (e.g.,
	              moving averages, Relative Strength Index), and patterns (e.g., head and shoulders, candlestick patterns),
	              to analyze historical market data.</p>
	            <p><b>Behavioral Analysis:</b> The core idea behind technical analysis is that historical price data
	              reflects human behavior in the market. Patterns and trends observed in the past are believed to have a
	              tendency to repeat themselves, providing insights into future price movements.</p>
	            <p><b> Psychology of Markets:</b> Technical analysts delve into the psychology of market participants,
	              understanding that traders and investors may react similarly under certain conditions. By identifying
	              patterns and trends, they attempt to anticipate market sentiment and potential price shifts.</p>
	            <p>Both approaches have their strengths and weaknesses, and the choice between them often depends on an
	              investor's or trader's preferences, time horizon, and objectives. It's important to note that while these
	              methods can provide valuable insights, market behavior can be unpredictable, leading to unexpected price
	              movements. Therefore, many market participants use a combination of both fundamental and technical
	              analysis to inform their decisions.</p>
	          </div>
	          <div class="balancing pt-3" id="investment">
	            <h3>Defining Investment Strategy</h3>
	            <p>An investment strategy is a comprehensive approach that individuals use to guide their investment
	              decisions with the aim of achieving their financial goals. These strategies can vary widely and encompass
	              various methods and approaches. Here's an overview of how investors define their investment strategies:
	            </p>

	            <p><b>Analyzing Economic Data: </b>Some investors base their strategies on macroeconomic indicators such as
	              Gross Domestic Product (GDP), inflation rates, interest rates, and unemployment rates. By analyzing these
	              economic data points, they aim to identify investment opportunities that align with broader economic
	              trends.</p>

	            <p><b>Company Analysis: </b>Others adopt a more company-specific approach. They delve deep into analyzing
	              individual companies' financial performance, market position, competitive advantages, and valuation
	              metrics. This approach allows them to make informed investment decisions based on a company's
	              fundamentals.</p>
	          </div>
	          <div class="investors pt-3" id="crafting">
	            <h3>Crafting a Well-Balanced Investment Portfolio</h3>
	            <p>Building a well-balanced investment portfolio is a strategic process that involves selecting and
	              combining various assets to achieve specific financial objectives while carefully managing risk and
	              return. To create an effective portfolio, investors analyze the characteristics and performance of each
	              asset under consideration, including factors like historical returns, volatility, liquidity, and
	              diversification potential.</p>
	            <h4>Correlation</h4>

	            <p>One of the pivotal considerations in portfolio construction is the correlation between different assets.
	              Correlation measures how the prices of two assets move in relation to each other over time. Understanding
	              correlation is essential because it helps investors assess how different assets may impact each other's
	              performance and risk within a portfolio.</p>

	            <p><b>Positive Correlation: </b>Assets with a positive correlation tend to move in the same direction. If
	              one asset's value increases, the other's tends to follow suit. Conversely, if one declines, the other
	              usually does as well.</p>

	            <p><b>Negative Correlation: </b> Assets with a negative correlation move in opposite directions. When one
	              asset's value increases, the other typically decreases, and vice versa.</p>

	            <p>By analyzing correlations, investors can construct a more diversified portfolio. For instance, assets
	              with high positive correlations may increase overall portfolio risk, while those with negative
	              correlations can help offset risk. Therefore, assessing correlations is crucial when building a
	              well-diversified portfolio.</p>
	            <h4>Weight in the Portfolio</h4>

	            <p>The weight assigned to each investment in a portfolio is another critical factor to consider. It
	              represents the percentage of the total portfolio value allocated to a particular asset. Properly managing
	              these weights is vital because they significantly influence the overall performance and risk of the
	              portfolio.</p>

	            <p><b>High Weight:</b> Assigning a high weight to an investment means it will have a more substantial impact
	              on the portfolio's returns and risk. If that investment performs poorly, it can expose the entire
	              portfolio to higher risk.</p>
	            <p><b> Low Weight: </b>Conversely, a low-weighted investment has a smaller impact on the portfolio's
	              performance and risk. If it underperforms, its effect on the overall portfolio is limited.</p>
	            <p>Balancing the weights of investments is crucial for achieving the desired risk-return characteristics in
	              a portfolio.</p>
	            <h4>Individual Security Risk</h4>
	            <p>Each individual investment in a portfolio carries its own level of risk or volatility. To create a
	              well-balanced portfolio, it's essential to consider the risk associated with each investment.</p>
	            <p><b>Diverse Risk Levels: </b>A well-diversified portfolio typically includes investments with varying
	              levels of risk. Combining assets with different risk profiles helps balance the overall risk and return
	              characteristics of the portfolio.</p>
	          </div>
	        </div>
	        <div class="glossary-content pb-5">
	          <h2 class="text-left">Types of Investment Strategies</h2>
	          <div class="border-heading"></div>
	          <div class="understanding pt-3" id="exploring">
	            <h3>Exploring Momentum Investing</h3>
	            <p>Momentum investing is an investment strategy that capitalizes on the momentum or trend of an asset's
	              price movement over a specific time period known as the Lookback Period. This strategy is grounded in the
	              belief that assets that have exhibited recent positive price momentum are more likely to continue rising,
	              while those with negative momentum may continue to decline.</p>
	            <p>Key aspects of Momentum Investing:</p>
	            <p><b> Momentum Indicator:</b> To assess an asset's momentum, investors calculate a momentum indicator for
	              each asset in their portfolio. This indicator is defined as:</p>
	            <p>
	            </p><pre>I(S) = (S(end) - S(start)) / S(start)</pre>
	            <p></p>
	            <p>S(end) represents the latest stock price. S(start) represents the stock price at the start of the
	              lookback period.</p>
	            <p><b>Customization: </b> Investors can customize their momentum strategy by adjusting parameters such as
	              the lookback period, buy and sell thresholds for the momentum indicator, and the rebalancing frequency.
	              These parameters allow for fine-tuning the strategy to align with specific investment objectives and risk
	              tolerances.
	            </p>
	            <p><b> Lookback vs. Backtest Period:</b> It's essential to differentiate between the lookback period and the
	              backtest period. The lookback period is the specific historical timeframe used to calculate the momentum
	              indicator for assets. In contrast, the backtest period is the historical window during which the
	              strategy's performance is simulated. The momentum indicator is recalculated at each rebalancing date
	              within the backtest period. </p>
	          </div>
	          <div class="balancing pt-3" id="value-investing">
	            <h3>Understanding Value Investing</h3>
	            <p>Value investing is an investment strategy that revolves around evaluating whether an asset's current
	              market price is above or below its intrinsic value. This strategy aims to identify opportunities where
	              assets are considered undervalued and may provide an attractive investment proposition. Here's a closer
	              look at the core principles of value investing:</p>
	            <p><b>Value Indicator:</b>At the heart of value investing is the use of a value indicator. This indicator is
	              designed to assess whether an asset's market price accurately reflects its intrinsic worth.</p>

	            <p><b>Intrinsic Value:</b></p>
	            <ul>
	              <li>The intrinsic value of an asset is the elusive concept that value investors seek to determine. It
	                represents what an asset should be worth, given various factors such as financial statements, industry
	                trends, and market news.</li>
	              <li>Multiple methods exist for estimating intrinsic value, including:
	                <ul>
	                  <li><b>Book Value: </b>Calculated as total assets minus liabilities.</li>
	                  <li><b>Discounted Cash Flows: </b>Evaluating the present value of expected future cash flows from
	                    owning the asset.</li>
	                  <li><b>Fundamental Analysis: </b>Examining key financial ratios (e.g., Earning Per Share, Price to
	                    Earnings ratio, Debt to Equity ratio) and company fundamentals.</li>
	                  <li><b>Industry Trends and Sentiment Analysis: </b>Assessing broader industry trends and considering
	                    the sentiment reflected in analyst reports.</li>
	                </ul>
	              </li>
	            </ul>
	            <p><b>Buy and Sell Signals:</b></p>
	            <ul>
	              <li>In value investing, a buy signal is generated when an asset is considered undervalued relative to its
	                intrinsic value. This suggests that the market price is lower than what the asset should be worth.</li>
	              <li>Conversely, a sell signal arises when an asset is believed to be overvalued compared to its intrinsic
	                value. In this case, the market price is considered higher than the asset's true worth.</li>
	            </ul>
	            <p><b>Consideration of Key Ratios:</b></p>
	            <ul>
	              <li>Assessing a company's fundamentals from its balance sheet is a common approach in value investing. Key
	                company ratios, such as Earning Per Share (EPS), Price to Earnings ratio (P/E), Price to Book Value
	                (P/BV), and others, play a vital role in this analysis.</li>
	              <li>These ratios offer valuable insights into a company's financial health, profitability, and valuation
	                compared to its peers and industry benchmarks.</li>
	            </ul>
	            <p><b>Challenges of Intrinsic Value Assessment:</b></p>
	            <ul>
	              <li>Determining an asset's intrinsic value is not an exact science. It involves weighing various factors
	                and making educated estimations.</li>
	              <li>The vast amount of information available makes it impractical to consider all factors comprehensively.
	              </li>
	            </ul>
	          </div>

	          <div class="investors pt-3" id="moving-average">
	            <h3>The Moving Average Strategy in Depth</h3>
	            <p>The Moving Average Strategy is a powerful tool in technical analysis that allows investors to gain
	              valuable insights into asset price trends, enabling informed decisions in building and managing investment
	              portfolios. This strategy involves observing stock prices and their associated moving averages to
	              anticipate future price movements. Here's a closer look at the core principles of the Moving Average
	              Strategy:</p>
	            <p><b>Moving Averages Defined:</b></p>
	            <ul>
	              <li>A moving average is a statistical calculation that smoothens out price data by creating a continually
	                updated average of an asset's prices over a specific time period.</li>
	              <li>This time period is defined by pre-determined averaging intervals, such as days, weeks, or months.
	                Common intervals include 50-day moving averages or 200-day moving averages.</li>
	            </ul>
	            <p><b>Interpreting Moving Averages:</b></p>
	            <ul>
	              <li>The shape and direction of the moving average line can serve as a valuable trade signal for predicting
	                the potential trajectory of an asset's price.</li>
	              <li>An upward-sloping moving average suggests that, on average, the asset's price is trending upward. This
	                indicates a potential uptrend in the asset's value.</li>
	              <li>Conversely, a downward-sloping moving average suggests that the asset's price is, on average, trending
	                downward, signaling a potential downtrend.</li>
	            </ul>
	            <p><b>Using Moving Averages for Trade Timing:</b></p>
	            <ul>
	              <li>In addition to assessing the overall direction of price trends, investors can use moving averages to
	                pinpoint potential entry and exit points in the market.</li>
	              <li>By analyzing the "tails" or deviations of the asset's price from the moving average line, investors
	                can identify potential price "floors" (support levels) and "ceilings" (resistance levels). These levels
	                can inform trading decisions during market upturns and downturns.</li>
	            </ul>
	            <p><b>Applications in Portfolio Management:</b></p>
	            <ul>
	              <li>The Moving Average Strategy is valuable for portfolio managers seeking to optimize asset allocation
	                and timing.</li>
	              <li>It can help investors decide when to buy or sell specific assets within their portfolio based on the
	                insights derived from moving averages.</li>
	            </ul>
	          </div>
	          <div class="investors pt-3" id="strength-indicators">
	            <h3>Demystifying Relative Strength Indicators</h3>
	            <p>Relative Strength Indicators (RSI) are a fundamental tool in technical analysis, designed to assess the
	              magnitude of recent price changes in an asset and gauge the momentum of its price movements. By tracking
	              rising and falling stock prices over a specific time frame, RSI helps investors identify potential trends
	              and reversals in asset prices. Here's an in-depth look at how RSI works:</p>
	            <p><b>Measuring Momentum:</b>RSI focuses on the pace at which an asset's prices are changing. It is
	              particularly concerned with identifying the momentum of upward and downward price movements.</p>
	            <p><b>Overbought and Oversold Conditions:</b></p>
	            <ul>
	              <li>RSI theory posits that when an asset experiences rapid price increases, it may become overbought. In
	                this scenario, investors might anticipate a reversal in price direction.</li>
	              <li>Conversely, when an asset undergoes a sharp decline in prices, it may be considered oversold,
	                indicating a potential price rebound.</li>
	            </ul>
	            <p><b>Calculation of RSI:</b></p>
	            <ul>
	              <li>RSI calculations begin by categorizing daily price movements into "up" and "down" movements.</li>
	              <li>"Up" price movements occur on days when the closing price exceeds the previous day's closing price.
	              </li>
	              <li>"Down" price movements occur on days when the closing price is less than the previous day's closing
	                price.
	              </li>
	              <li>An exponential moving average (EMA) is then computed separately for both "up" and "down" movements.
	                EMAs provide greater weight to recent price data, capturing the most current market conditions.</li>
	              <li>These moving averages are used to calculate the Relative Strength factor.</li>
	              <li>The RSI is derived from the Relative Strength factor, yielding the final RSI value.</li>
	            </ul>
	            <p><b>Interpreting RSI Values:</b></p>
	            <ul>
	              <li>RSI values typically range from 0 to 100.</li>
	              <li>When the RSI crosses or equals 70, it suggests that the asset is overbought, potentially signaling a
	                reversal in the upward price trend.</li>
	              <li>Conversely, when the RSI crosses or equals 30, it indicates that the asset is oversold, which may
	                foreshadow a potential upward price correction.</li>
	            </ul>
	          </div>
	          <div class="investors pt-3" id="volume-investment">
	            <h3>Exploring On-Balance Volume (OBV) in Investment</h3>
	            <p>On-Balance Volume (OBV) is a technical analysis indicator that focuses on tracking the momentum of
	              trading volumes associated with an asset. This indicator is utilized to identify potential divergences
	              between trading volumes and asset prices, which can signal a weakening price trend and a potential
	              reversal in direction. Here's an in-depth exploration of OBV in investment:</p>
	            <p><b>The Volume-Price Relationship:</b>OBV is built on the foundational principle that price movements tend
	              to follow trading volume. When trading volumes increase significantly, it can signal strong interest and
	              participation in the asset.</p>
	            <p><b>Detecting Price and Volume Divergence:</b>The primary objective of OBV is to identify situations where
	              trading volumes are exhibiting a divergence from the asset's price movement. This divergence can suggest
	              that the prevailing price trend is losing momentum and may be ripe for a reversal.</p>
	            <p><b>Calculating OBV:</b></p>
	            <ul>
	              <li>OBV is calculated by aggregating trading volumes over specific time periods.</li>
	              <li>On days when the closing price is higher than the previous day's closing price (up days), the volume
	                is added to the OBV.</li>
	              <li>Conversely, on days when the closing price is lower than the previous day's closing price (down days),
	                the volume is subtracted from the OBV.</li>
	              <li>The cumulative OBV value is plotted on a chart, reflecting the ongoing relationship between trading
	                volumes and asset prices.</li>
	            </ul>
	            <p><b>Interpreting OBV:</b></p>
	            <ul>
	              <li>Rising OBV values indicate that trading volumes are predominantly higher on up days, suggesting strong
	                buying interest and potential upward price momentum.</li>
	              <li>Declining OBV values suggest that trading volumes are mainly higher on down days, indicating increased
	                selling pressure and potential downward price momentum.</li>
	              <li>"Down" price movements occur on days when the closing price is less than the previous day's closing
	                price.
	              </li>
	              <li>An exponential moving average (EMA) is then computed separately for both "up" and "down" movements.
	                EMAs provide greater weight to recent price data, capturing the most current market conditions.</li>
	              <li>These moving averages are used to calculate the Relative Strength factor.</li>
	              <li>Divergences between OBV and price trends can provide valuable signals. For instance, if OBV is rising
	                while prices are falling (bullish divergence), it may suggest an impending price reversal to the upside.
	              </li>
	            </ul>
	            <p><b>Applications in Investment:</b></p>
	            <ul>
	              <li>OBV can be used by investors to assess the strength of a prevailing price trend and identify potential
	                turning points.</li>
	              <li>It is particularly valuable for identifying shifts in market sentiment, as changes in trading volumes
	                often precede price movements.</li>
	            </ul>
	          </div>
	          <div class="investors pt-3" id="dividend-Investing">
	            <h3>Diving into Dividend Investing</h3>
	            <p>Dividend investing is a strategy that focuses on acquiring stocks from companies that regularly
	              distribute a portion of their earnings to shareholders. These distributions typically take the form of
	              cash payments and offer investors a reliable source of income. Here's a closer look at dividend investing:
	            </p>
	            <p><b>Regular Income Stream:</b>Dividend investing revolves around the concept of generating a consistent
	              income stream from investments. By holding stocks that pay dividends, investors can receive periodic cash
	              payments from the company.</p>
	            <p><b>Exposure to Market Price Movements:</b>While dividend investing provides an income stream, it doesn't
	              shield investors from exposure to market price fluctuations. The market value of dividend-paying stocks
	              can still rise and fall based on various factors, including market sentiment, economic conditions, and
	              company performance.</p>
	            <p><b>Yield Variability:</b></p>
	            <ul>
	              <li>It's essential to understand that the yield from dividend payments can change over time. This
	                variability is influenced by several factors, including:
	                <ul>
	                  <li><b>Stock Price Movements: </b>Changes in the market value of the stock can affect the dividend
	                    yield. For example, if the stock price increases, the yield may decrease, and vice versa.</li>
	                  <li><b>Company Performance: </b>The financial health and profitability of the company impact its
	                    ability to sustain and grow dividend payments. A financially robust company may increase its
	                    dividends over time, while a struggling company may reduce or eliminate them.</li>
	                </ul>
	              </li>
	            </ul>
	            <p><b>Benefits of Dividend Investing:</b></p>
	            <ul>
	              <li><b> Income Generation:</b> Dividend payments provide a regular income stream, making this strategy
	                particularly attractive to investors seeking consistent cash flow.</li>
	              <li><b>Long-Term Wealth Accumulation: </b> Reinvesting dividends can accelerate the growth of an
	                investment portfolio over time. By purchasing additional shares with dividend income, investors can
	                potentially benefit from compounding returns.</li>
	              <li><b>Portfolio Diversification:</b> Dividend-paying stocks can be an essential component of a
	                diversified investment portfolio. They offer the potential for both income and capital appreciation.
	              </li>
	            </ul>
	            <p><b>Risks and Considerations:</b></p>
	            <ul>
	              <li>While dividend investing has its advantages, it's not without risks:
	                <ul>
	                  <li><b>Market Volatility: </b>Dividend-paying stocks are still subject to market volatility, and their
	                    prices can fluctuate significantly.</li>
	                  <li><b>Company Risk: </b>The financial health of the company plays a crucial role in sustaining
	                    dividend payments. Investing in companies with unstable financials can be risky.</li>
	                  <li><b>Interest Rate Sensitivity: </b>Dividend stocks can be sensitive to changes in interest rates.
	                    Rising interest rates may make dividend yields less attractive, potentially affecting stock prices.
	                  </li>
	                </ul>
	              </li>
	            </ul>
	          </div>
	          <div class="investors pt-3" id="comprehensive">
	            <h3>Comprehensive Guide to the Moving Average Convergence Divergence (MACD) Strategy</h3>
	            <p>The Moving Average Convergence Divergence, commonly known as MACD, is a powerful indicator used in
	              technical analysis to identify trend changes and generate buy or sell signals. Unlike simple moving
	              averages (SMA), the MACD is based on Exponential Moving Averages (EMA), giving greater weight to recent
	              price data. Here's an in-depth guide to understanding and utilizing the MACD strategy:</p>
	            <h4>Components of MACD:</h4>
	            <p><b>MACD Line:</b> The MACD line represents the difference between two EMAs – a short-term EMA (typically
	              based on 12 periods) and a long-term EMA (usually based on 26 periods). The MACD line illustrates the
	              convergence and divergence between these two moving averages. When the MACD line trends downward, it
	              signifies that the short-term EMA is losing ground to the long-term EMA. The MACD line oscillates between
	              positive and negative values.</p>
	            <p>
	            </p><pre>MACD = EMA(12) - EMA(26)</pre>
	            <p></p>
	            <p><b>Signal Line: </b>The signal line is another EMA, typically based on the MACD line itself, with a
	              shorter lookback period (often 9 periods). It aims to smooth out the MACD line's movements and identify
	              potential changes in its direction.</p>
	            <p>
	            </p><pre>Signal Line = EMA(9) of MACD</pre>
	            <p></p>
	            <p><b>Histogram: </b>The histogram is the visual representation of the difference between the MACD line and
	              the signal line. It helps traders observe when one line crosses over the other.</p>
	            <h4>Interpreting MACD:</h4>
	            <p>The MACD can be interpreted in several ways:</p>
	            <p><b>Crossovers:</b> The most common interpretation involves crossovers between the MACD line and the
	              signal line.</p>
	            <ul>
	              <li><b>Buy Signal: </b> When the MACD crosses above the signal line (with both below the zero line), it
	                generates a "buy" signal, indicating potential upward momentum.</li>
	              <li><b>Sell Signal:</b> Conversely, when the MACD crosses below the signal line (with both above the zero
	                line), it generates a "sell" signal, suggesting potential downward momentum.</li>
	            </ul>
	            <p><b>Histogram Height: </b>Although there's no specific threshold, a rising histogram height indicates
	              increasing momentum. Traders often look for the histogram to gain height, signaling a potential trend
	              reversal.</p>
	            <p><b>Divergence:</b> Divergence occurs when the price chart shows higher highs or lower lows, while the
	              MACD chart displays the opposite pattern. This divergence can indicate a potential trend reversal.</p>
	            <h4>Parameter Customization:</h4>
	            <p>While the conventional MACD parameters are 12, 26, and 9 for the EMA lookback periods, traders have the
	              flexibility to customize these parameters based on their analysis preferences and market conditions.</p>
	            <h4>How MACD Works:</h4>
	            <ul>
	              <li>MACD helps traders identify changes in trend momentum and potential reversal points.</li>
	              <li>It provides three primary types of signals: crossovers, histogram height, and divergence.</li>
	              <li>Traders often use MACD in conjunction with other technical indicators and analysis methods for a
	                comprehensive assessment of market conditions.</li>
	            </ul>
	          </div>
	        </div>
	        <div class="glossary-content pb-5">
	          <h2 class="text-left">Sustainable Investment Approaches</h2>
	          <div class="border-heading"></div>
	          <div class="understanding pt-3" id="significance">
	            <h3>Understanding ESG Ratings and Their Significance</h3>
	            <p>ESG, which stands for Environmental, Social, and Governance, has become a critical consideration for
	              investors looking to align their investments with ethical values and sustainability goals. ESG ratings
	              help investors assess a company's commitment to these principles and make informed investment decisions.
	              Let's delve into each component of ESG ratings and why they matter:</p>
	            <p><b>Environmental:</b></p>
	            <ul>
	              <li>The Environmental rating evaluates a company's dedication to preserving the natural world.</li>
	              <li>Key factors include energy consumption, waste production, and overall environmental impact.</li>
	              <li>For example, a company that opts for eco-friendly practices, such as using paper straws instead of
	                plastic, earns a favorable environmental rating.</li>
	              <li>Conversely, businesses contributing to environmental harm, like those involved in deforestation,
	                receive lower environmental ratings.</li>
	            </ul>
	            <p><b>Social:</b></p>
	            <ul>
	              <li>The Social rating assesses how a company treats its employees, engages with the community, and
	                participates in socially responsible initiatives.</li>
	              <li>It considers factors like employee wages, benefits, diversity and inclusion efforts, volunteer
	                programs, and philanthropy.</li>
	              <li>Companies that work toward leveling social inequalities and improving workplace conditions earn higher
	                social ratings.</li>
	              <li>Businesses exploiting cheap labor or neglecting social responsibility receive lower social ratings.
	              </li>
	            </ul>
	            <p><b>Governance:</b></p>
	            <ul>
	              <li>Governance focuses on an organization's management practices and decision-making processes.</li>
	              <li>It evaluates how well a company serves the interests of shareholders, customers, and the wider
	                community.
	              </li>
	              <li>Strong governance is reflected in companies that prioritize the well-being of external stakeholders.
	              </li>
	              <li>Weak governance is associated with self-serving executives primarily concerned with personal gain.
	              </li>
	              <li>Governance ratings are critical in assessing ethical conduct and responsible decision-making.</li>
	              <li>Companies with poor governance may be involved in corporate scandals and misconduct.</li>
	            </ul>

	            <p><b> Significance of ESG Ratings:</b></p>
	            <ul>
	              <li>ESG ratings help investors identify companies that align with their ethical values and sustainability
	                goals.</li>
	              <li>These ratings provide a framework for evaluating a company's overall impact on the environment,
	                society, and governance practices.</li>
	              <li>Investors increasingly consider ESG ratings when making investment decisions to support responsible
	                and sustainable businesses.</li>
	              <li>High ESG ratings can indicate a company's commitment to long-term sustainability, potentially leading
	                to better financial performance.</li>
	              <li>Low ESG ratings may raise concerns about a company's ethical practices and expose it to reputational
	                and operational risks.</li>
	            </ul>
	          </div>
	          <div class="balancing pt-3" id="sustainable-investing">
	            <h3>Assessing Carbon Emissions in Sustainable Investing</h3>
	            <p>In the quest for sustainable investing, one of the <b>paramount considerations</b> is the assessment of
	              carbon emissions and their profound impact on the environment. Carbon emissions, primarily in the form of
	              carbon dioxide (CO2), result from human activities such as burning fossil fuels and deforestation. These
	              emissions disrupt the delicate balance of natural CO2 levels, essential for the Earth's carbon cycles
	              within the atmosphere, water, and land.</p>

	            <p><b>The Consequences of Excess Carbon Emissions:</b></p>
	            <ul>
	              <li>Excessive carbon emissions, especially from human-related activities, contribute to the greenhouse
	                effect, trapping heat in the Earth's atmosphere.</li>
	              <li>This trapped heat leads to rising global temperatures, a phenomenon known as global warming, which is
	                a primary driver of climate change.</li>
	              <li>The effects of climate change manifest in various interrelated ways, including more frequent and
	                severe weather events, sea-level rise, and disruptions to ecosystems and biodiversity.</li>
	            </ul>

	            <p><b>Measuring Carbon Emissions:</b></p>
	            <ul>
	              <li>Carbon emissions are quantified in units known as CO2e (carbon dioxide equivalent), which represent
	                the potential impact of emissions from a specific human activity.</li>
	              <li>Smaller CO2e units indicate a lesser environmental impact associated with that activity.</li>
	              <li>Businesses and organizations strive to measure the carbon emissions generated at each stage of their
	                processes to assess their carbon footprint.</li>
	              <li>A carbon footprint encompasses the cumulative emissions over a defined timeframe and offers insights
	                into the extent of polluting activities engaged in by an entity.</li>
	            </ul>

	            <p><b>Significance in Sustainable Investing:</b></p>
	            <ul>
	              <li>Sustainable investors recognize the critical importance of understanding carbon emissions and their
	                implications.</li>
	              <li>Evaluating the carbon footprint of companies and investment opportunities informs decisions regarding
	                environmentally responsible investments.</li>
	              <li>Sustainable investors seek to support businesses that actively work to reduce their carbon emissions
	                and promote environmentally friendly practices.</li>
	              <li>By aligning investments with low-carbon or carbon-neutral companies, investors contribute to
	                mitigating climate change and fostering a more sustainable future.</li>
	              <li>Sustainable investing not only considers financial returns but also aims to address pressing
	                environmental and social challenges.</li>
	            </ul>
	          </div>
	          <div class="investors pt-3" id="exploring-methane">
	            <h3>Exploring Methane Emissions in Sustainable Investment Strategies</h3>
	            <p>Methane emissions, much like carbon emissions, represent a critical aspect of the sustainability
	              landscape, with profound implications for our environment and the ongoing climate crisis. Methane, a
	              potent greenhouse gas, exerts detrimental effects when released into the atmosphere without undergoing
	              combustion. In fact, a significant portion of methane emissions—approximately 60%—is attributed to human
	              activities.</p>

	            <p><b>Human-Induced Methane Emissions:</b></p>
	            <ul>
	              <li>Agriculture: Agriculture stands as a prominent contributor to methane emissions, accounting for 40% of
	                total methane emissions resulting from human activities. Livestock cultivation, including cattle and
	                other ruminants, produces methane during digestion through a process known as enteric fermentation.
	                Additionally, rice cultivation in flooded fields can generate methane emissions.</li>
	              <li>Waste Landfilling: Methane emissions arise from the decomposition of organic matter in landfills,
	                where anaerobic conditions prevail. Without effective waste management strategies, methane is released
	                into the atmosphere during this decomposition process.</li>
	              <li>Fossil Fuel and Gas Production: The extraction, processing, and transportation of fossil fuels and
	                natural gas can lead to methane leaks and emissions. Methane is a primary component of natural gas, and
	                its release into the atmosphere during these processes contributes to greenhouse gas concentrations.
	              </li>
	            </ul>

	            <p><b>The Consequences of Methane Emissions:</b></p>
	            <ul>
	              <li>Methane is a potent greenhouse gas, with a much higher heat-trapping potential than carbon dioxide
	                (CO2) over a shorter timescale.</li>
	              <li>Excessive methane emissions exacerbate global warming and contribute to climate change, leading to
	                adverse impacts such as rising temperatures, sea-level rise, and disruptions to ecosystems.</li>
	            </ul>

	            <p><b>Methane Mitigation in Sustainable Investing:</b></p>
	            <ul>
	              <li>Sustainable investment strategies recognize the critical importance of addressing methane emissions as
	                part of environmental stewardship.</li>
	              <li>Investors seek opportunities to support companies and initiatives that actively work to reduce methane
	                emissions through responsible agricultural practices, waste management, and emissions control in fossil
	                fuel and gas operations.</li>
	              <li>By aligning investments with entities committed to mitigating methane emissions, sustainable investors
	                play a role in combatting climate change and promoting sustainable environmental practices.</li>
	              <li>Methane reduction efforts are integral to achieving greenhouse gas reduction targets outlined in
	                international climate agreements, such as the Paris Agreement.</li>
	            </ul>
	          </div>
	        </div>
	        <div class="glossary-content pb-5">
	          <h2>Foundations of Investment</h2>
	          <div class="border-heading"></div>
	          <div class="investors pt-3" id="diversification-investments">
	            <h3>Principles of Diversification in Investments</h3>
	            <p>Diversification is a fundamental concept in the world of investing, aimed at managing risk and achieving
	              a well-balanced investment portfolio. It involves spreading your investments across a range of assets,
	              rather than concentrating them in a single asset or a few. This approach is based on the idea that holding
	              multiple assets with different risk profiles can help reduce overall portfolio volatility and enhance the
	              potential for long-term returns. Here are some key principles of diversification in investments:</p>

	            <p><b>1. Risk Reduction Through Asset Variety:</b></p>
	            <p>Diversification involves investing in different types of assets, such as stocks, bonds, real estate, and
	              commodities. By holding a variety of assets with distinct risk-return characteristics, investors can
	              reduce their exposure to the risks associated with any single asset class.</p>

	            <p><b>2. Correlation Matters:</b></p>
	            <p>The effectiveness of diversification depends on the correlation between assets. Negatively correlated or
	              uncorrelated assets tend to move in different directions in response to market events. For example, when
	              one asset's price rises, another may fall or remain stable. This can help mitigate portfolio volatility.
	              Conversely, positively correlated assets move in the same direction, potentially increasing portfolio
	              risk.</p>

	            <p><b>3. Geographic and Sectoral Diversification:</b></p>
	            <p>Geographic diversification involves investing in assets from different regions or countries. Similarly,
	              sectoral diversification entails holding assets from various sectors of the economy, such as technology,
	              healthcare, or finance. These strategies can further reduce risk by minimizing exposure to regional or
	              sector-specific economic fluctuations.</p>

	            <p><b>4. Portfolio Size and Risk Tolerance:</b></p>
	            <p>The level of diversification required may vary based on an individual's risk tolerance. Investors with a
	              lower risk tolerance may opt for larger and more diversified portfolios to spread risk. Conversely, those
	              with a higher risk tolerance may choose a more focused portfolio.</p>

	            <p><b>5. Monitoring and Rebalancing:</b></p>
	            <p>Diversified portfolios require ongoing monitoring and periodic rebalancing. As asset values change over
	              time, the original asset allocation may shift. Rebalancing involves adjusting the portfolio to maintain
	              the desired asset mix and risk profile.</p>

	            <p><b>6. Potential Benefits:</b></p>
	            <p>Diversification aims to achieve several benefits, including reduced portfolio volatility, preservation of
	              capital during market downturns, and improved risk-adjusted returns. It can also provide exposure to a
	              broader range of investment opportunities.</p>

	            <p><b>7. Avoiding Over-Diversification:</b></p>
	            <p>While diversification is essential, it's possible to over-diversify a portfolio. Holding too many assets
	              can make it challenging to monitor and manage effectively. Investors should strike a balance between
	              diversification and the practicality of portfolio management.</p>
	          </div>
	          <div class="investors pt-3" id="understanding">
	            <h3>Understanding and Managing Volatility in Portfolios</h3>
	            <p>In the world of investing, volatility refers to how much an asset's returns vary over a certain period of
	              time. When volatility is high, the price of an asset bounces up and down quickly, showing rapid rise and
	              fall. On the other hand, lower volatility means that an asset's value doesn't change dramatically and is
	              more stable. Investors who are willing to take higher risks tend to prefer assets with higher volatility,
	              as they can potentially experience bigger gains. However, those who are more cautious and prefer stability
	              in their investments look for lower volatility in their portfolios. Understanding volatility is important
	              when deciding which investments align with your risk appetite and financial goals.</p>
	          </div>
	          <div class="investors pt-3" id="Investment-Assets">
	            <h3>Exploring Correlation in Investment Assets</h3>
	            <p>Correlation is a statistical term that describes how two variables are related in terms of their strength
	              and direction. When there is a positive correlation, both variables move in the same direction, while a
	              negative correlation means they move in opposite directions. The strength of the correlation indicates the
	              extent to which one variable can explain the other in a linear manner.</p>
	            <p>In the world of investment, portfolios that have negative or weak positive correlations among their
	              assets can help reduce overall volatility and risk. On the other hand, portfolios with higher positive
	              correlations among their assets entail higher levels of risk and volatility.</p>
	          </div>
	          <div class="investors pt-3" id="Assessing-Profitability">
	            <h3>Assessing Profitability Metrics in Investment Analysis</h3>
	            <p>Understanding profitability is crucial in assessing a company's efficient utilization of capital and its
	              potential for growth and financial stability. Higher profitability enables businesses to achieve greater
	              returns on their investments, contributing to long-term success. By carefully analyzing profitability,
	              organizations can ensure optimal resource allocation and make informed decisions to enhance their
	              performance.</p>
	          </div>
	          <div class="investors pt-3" id="Significance-Rate">
	            <h3>The Significance of Rate of Return in Investments</h3>
	            <p>The rate of return on an investment is the percentage change in its value over a period of time. To
	              calculate this, divide the present value of the investment by the original value, subtract 1, and multiply
	              by 100.</p>
	            <p>For example, if your asset was initially worth £1,000 and a year later it's worth £1,100, the annual rate
	              of return would be 10%:</p>
	            <p>(1,100 - 1,000 / 1,000) × 100 =10%</p>
	          </div>
	          <div class="investors pt-3" id="Investment-Projections">
	            <h3>Calculating Expected Returns in Investment Projections</h3>
	            <p>Investors often seek to estimate the potential returns of their investments, taking into account
	              different scenarios and their associated probabilities. Calculating the expected return is a fundamental
	              step in investment analysis, helping investors make informed decisions. Here's how expected returns are
	              calculated:</p>
	            <p><b>1. Understand the Components:</b></p>
	            <p>Expected return is represented as E(R), where "E" stands for expected, and "R" represents the return.
	              It's a measure of the average outcome an investor can anticipate from an investment.</p>
	            <p><b>2. Multiple Scenarios:</b></p>
	            <p>To calculate the expected return, investors consider multiple scenarios, each with its associated rate of
	              return (R). These scenarios can encompass various economic conditions, market events, or investment
	              outcomes.</p>
	            <p><b>3. Assign Probabilities:</b></p>
	            <p>Alongside each scenario, probabilities (P) are assigned, indicating the likelihood of that particular
	              scenario occurring. These probabilities should add up to 1 (or 100%).</p>
	            <p><b>4. Calculate the Expected Return:</b></p>
	            <p>The expected return (E(R)) is calculated by summing the products of each scenario's return (R) and its
	              corresponding probability (P). Mathematically, it's represented as: <br> E(R) = Σ (Ri * Pi) <br>Where:
	              <br>E(R) = Expected return <br>Ri = Return for scenario "i" <br>Pi = Probability of scenario "i" occurring
	              <br>Σ denotes summation, indicating that you should perform this calculation for all scenarios (from i = 1
	              to n, where n is the total number of scenarios).
	            </p>
	            <p><b>5. Interpretation:</b></p>
	            <p>The resulting expected return provides investors with an estimate of the average outcome they can expect
	              from their investment under the given scenarios and associated probabilities.</p>
	            <p><b>Example:</b></p>
	            <p>Suppose an investor is considering two scenarios for an investment:</p>
	            <ul>
	              <li>Scenario 1: Expected return (R1) = 8% with a probability (P1) of 0.6 (60%).</li>
	              <li>Scenario 2: Expected return (R2) = 2% with a probability (P2) of 0.4 (40%).</li>
	            </ul>
	            <p>The expected return for this investment would be calculated as follows:</p>
	            <p>E(R) = (0.6 * 0.08) + (0.4 * 0.02) = 0.048 + 0.008 = 0.056 or 5.6%</p>
	            <p>In this example, the expected return for the investment is 5.6%, indicating that, on average, the
	              investor can anticipate a return of 5.6% based on the provided scenarios and their probabilities.</p>
	          </div>
	          <div class="investors pt-3" id="liquidity">
	            <h3>A Key Factor of Liquidity</h3>
	            <p>Liquidity is a critical concept in the world of investments, influencing various aspects of investment
	              decision-making. It refers to the degree of ease with which assets can be bought or sold in a market
	              without significantly affecting the asset's price. Liquidity plays a pivotal role in shaping investment
	              strategies and risk management.</p>

	            <p><b>Market Liquidity:</b></p>
	            <ul>
	              <li>Market liquidity is a measure of how easily an asset, such as a stock or bond, can be traded in the
	                market. Highly liquid assets can be bought or sold quickly and with minimal price impact, thanks to
	                ample trading activity and a tight spread (the difference between the bid price and ask price).</li>
	              <li>Conversely, assets with low liquidity may experience larger price spreads and may require more time
	                and effort to execute trades. This can result from limited trading volume or a lack of interested buyers
	                or sellers.</li>
	            </ul>

	            <p><b>Asset Liquidity:</b></p>
	            <ul>
	              <li>Liquidity can also be assessed at the individual asset level. Some assets are naturally more liquid
	                than others. For example, cash is the most liquid asset as it can be readily used to settle financial
	                obligations.</li>
	              <li>Tangible assets, such as real estate or artwork, tend to be less liquid because they often require
	                more time and effort to convert into cash without significantly affecting their market value.</li>
	            </ul>

	            <p><b>Market Conditions:</b></p>
	            <p>Liquidity in financial markets can vary depending on market conditions. During periods of high volatility
	              or market stress, liquidity can dry up, causing wider spreads and making it more challenging to execute
	              large trades without impacting prices.</p>

	            <p><b>Impact on Prices:</b></p>
	            <p>Liquidity can significantly impact asset prices. When there is a balance between buy and sell orders,
	              prices tend to remain stable. However, if there is an imbalance, with more sell orders than buy orders,
	              prices can fall, and vice versa.</p>
	          </div>
	          <div class="investors pt-3" id="Capital-Allocation">
	            <h3>Capital Allocation</h3>
	            <p>Capital allocation is a fundamental aspect of corporate financial management. It encompasses the process
	              of effectively distributing and reinvesting a company's financial resources across various areas of the
	              business. The primary objectives of strategic capital allocation are to maximize profits, enhance
	              efficiency, and promote financial stability and resilience. Directors aim to allocate in ways which will
	              generate the highest returns for its shareholders providing capital.</p>
	          </div>
	          <div class="investors pt-3" id="Dividends">
	            <h3>Dividends</h3>
	            <p>Dividends represent a fundamental aspect of corporate finance and serve as a means of distributing a
	              portion of a company's earnings to its shareholders. These regular payments are typically made in the form
	              of cash or additional stock and play a pivotal role in shaping the financial landscape of both companies
	              and their investors.</p>
	          </div>
	          <div class="investors pt-3" id="Balance-Sheet">
	            <h3>Balance Sheet</h3>
	            <p>A balance sheet is a concise overview of data that enables us to evaluate a company's financial status at
	              a specific moment. This overview encompasses total values for assets, liabilities, and equity. A robust
	              balance sheet is closely tied to effective financial and operational performance, as well as resilience
	              during economic challenges. The financial data contained in a balance sheet serves as a foundation for
	              computing financial ratios, providing valuable insights for investors. </p>
	            <p>The fundamental equation of the balance sheet, widely recognized in finance and accounting, is as
	              follows:</p>
	            <p>Total Assets = Total Liabilities + Total Equity</p>
	          </div>
	          <div class="investors pt-3" id="Income-Statement">
	            <h3>Income Statement</h3>
	            <p>An Income Statement bears resemblance to a Balance Sheet by offering a momentary glimpse of valuable
	              financial data at a specific juncture. However, its primary focus is on a company's revenue. This
	              information can be scrutinized to determine if a given company is earning profits during a particular
	              timeframe, shedding light on its overall financial well-being and performance.</p>
	            <p>The formula for calculating Net Income is as follows:</p>
	            <p>Net Income = (Revenue + Gains) - (Expenses + Losses)</p>
	            <p>Gains and Losses encompass singular, non-recurring transactions, such as a profitable sale of a long-term
	              asset or a loss incurred from a similar sale.</p>
	          </div>
	        </div>
	        <div class="glossary-content pb-5">
	          <h2>Financial Ratio Essentials</h2>
	          <div class="border-heading"></div>
	          <div class="investors pt-3" id="Payout-Ratio">
	            <h3>Understanding the Dividend Payout Ratio</h3>
	            <p>The dividend payout ratio evaluates the total dividend payments as a fraction of the company's overall
	              income. This metric is valuable in assessing the extent to which a company distributes its earnings to
	              shareholders in the form of dividends.</p>
	            <p>For instance, consider Company A with earnings per share of £1 and dividend payments per share of £0.50;
	              their dividend payout ratio (DPR) would be 50% (0.5/1). In contrast, Company B, with earnings per share of
	              £1 and dividend payments per share of £0.60, would have a DPR of 60% (0.60/1).</p>
	            <p>Consequently, Company B disburses a higher proportion of its earnings to shareholders through dividend
	              payments.</p>
	            <p>DPR Formula: DPR = Total Dividends / Net Income</p>
	          </div>
	          <div class="investors pt-3" id="Share-Ratio">
	            <h3>Analyzing the Dividend Per Share Ratio</h3>
	            <p>Dividend per share ratios serve as a means to assess the extent of income distributed by a company to its
	              investors through dividend disbursements. This is computed by dividing the total amount of dividends paid
	              over a specific timeframe by the number of outstanding shares. A higher ratio indicates a greater
	              allocation of income to shareholders.</p>
	            <p>The formula to compute this ratio is as follows, where D represents the total dividends over the period,
	              SD signifies special dividends for the period (usually excluded as they are expected to be issued once),
	              and S represents the shares outstanding during the period:</p>
	            <p>DPS = (D - SD) / S</p>
	            <p>As an illustration, let's consider Company X, which has 1,000,000 shares outstanding and paid £200,000 in
	              dividends over the year, including a one-time dividend of £50,000. In this case, the DPS ratio would be
	              calculated as follows: [(200,000 - 50,000) / 1,000,000] = £0.15.</p>
	          </div>
	          <div class="investors pt-3" id="Per-Share">
	            <h3>Earnings Per Share (EPS)</h3>
	            <p>Earnings per share (EPS) stands as a valuable metric employed to assess a company's corporate value and
	              profitability. A high EPS ratio signifies that a company generates substantial income for each share of
	              its stock, calculated by dividing a company's profit by the average number of outstanding shares over a
	              specified period. A company exhibiting positive EPS growth without any earnings deficits over a 5-year
	              timeframe is typically considered to have lower risk compared to a company with negative EPS.</p>
	            <p>The formula for calculating EPS is as follows, with Preferred Dividends representing cash dividends
	              disbursed to preferred shareholders from the company's Net Income:</p>
	            <p>EPS = (Net Income - Preferred Dividends) / Shares Outstanding</p>
	            <p>For instance, let's take Company C as an example, which generates £7.5 million in net income, pays
	              £500,000 in preferred dividends, and has 3 million shares outstanding. In this case, EPS would be computed
	              as follows: [(7.5 - 0.5) / 3] = £2.33.</p>
	          </div>
	          <div class="investors pt-3" id="Earnings-Ratio">
	            <h3>Price to Earnings (P/E) Ratio</h3>
	            <p>The Price-to-Earnings (P/E) ratio is a metric that evaluates a company's current stock price in relation
	              to its earnings per share. It serves as a valuable tool for assessing the valuation of companies and their
	              assets, helping to determine whether they are overvalued or undervalued. Additionally, it can be compared
	              to stocks within the same industry or the broader market to gain insights.</p>
	            <p>A low P/E ratio may suggest that the share price has declined while earnings per share have remained
	              relatively stable. Conversely, a higher P/E ratio indicates that the share price has risen faster than
	              earnings, often implying optimism about future growth and strong performance, which could lead to higher
	              future earnings.</p>
	            <p>The formula to calculate the P/E ratio is straightforward:</p>
	            <p>P/E = Share Price / Earnings Per Share</p>
	          </div>
	          <div class="investors pt-3" id="Value-Ratio">
	            <h3>Price to Book Value (P/BV) Ratio</h3>
	            <p>The Price to Book Value (P/BV) ratio is a metric that assesses a company's current market value relative
	              to its book value, which represents the cost of including an asset on the company's balance sheet. In the
	              event of a company's liquidation, the book value would determine the value of assets that shareholders
	              would receive. By factoring in a company's market price for comparison, we can determine whether a stock
	              is overvalued or undervalued and establish a fair value for trading purposes.</p>
	            <p>Stocks trading close to or below their book value may indicate that they are undervalued, trading at a
	              price lower than the company's underlying value. On the other hand, a higher P/BV ratio may suggest that
	              the stock is overvalued, trading at a price higher than the company's underlying value.</p>
	            <p>The formula to calculate the Price to Book Value ratio is as follows:</p>
	            <p>P/BV = Stock Price Per Share / Book Value Per Share</p>
	          </div>
	          <div class="investors pt-3" id="Asset-Value">
	            <h3>Net Asset Value (NAV)</h3>
	            <p>Net Asset Value (NAV) offers a per-share assessment of a company's assets and is a valuable tool for
	              identifying potential investment opportunities. To calculate NAV, one subtracts the total value of
	              liabilities from the total assets to arrive at the net value, which is then divided by the number of
	              shares outstanding.</p>
	            <p>The formula to compute Net Asset Value is as follows:</p>
	            <p>NAV = (Total Assets - Total Liabilities) / Shares Outstanding</p>
	          </div>
	          <div class="investors pt-3" id="Current-Ratio">
	            <h3>Current Ratio</h3>
	            <p>The Current Ratio is a metric used to assess a company's short-term liquidity, offering insights into its
	              ability to meet pending liabilities while potentially generating cash from its current assets. This ratio
	              is instrumental in gauging the financial health of an entity.</p>
	            <p>As a general guideline, it is advisable to seek companies with ratios above 1.5 to be considered
	              financially healthy. However, acceptable ratios may vary by industry, and a ratio below 1 could indicate
	              potential liquidity challenges.</p>
	            <p>To calculate the Current Ratio, use the formula provided below:</p>
	            <p>CR = Current Assets / Current Liabilities</p>
	          </div>
	          <div class="investors pt-3" id="Quick-Ratio">
	            <h3>Quick Ratio</h3>
	            <p>The Quick Ratio, also known as the Acid-Test Ratio, is a metric used to evaluate a company's liquidity by
	              measuring its ability to settle all outstanding liabilities using its most liquid assets. A higher Quick
	              Ratio suggests strong liquidity and financial stability, indicating a greater likelihood that the company
	              can meet its debt obligations.</p>
	            <p>To calculate the Quick Ratio, utilize the provided formula:</p>
	            <p>QR = Quick Assets / Current Liabilities</p>
	            <p>For instance, consider Company D, which possesses £37,000 in Quick Assets and faces £40,000 in Current
	              Liabilities. In this case, the Quick Ratio for Company D is calculated as follows: QR = £37,000 / £40,000
	              = 0.93. Therefore, Company D is in a favorable position, as it can nearly cover each pound of its
	              short-term obligations with its most liquid assets.</p>
	          </div>
	          <div class="investors pt-3" id="Equity-Ratio">
	            <h3>Debt to Equity (D/E) Ratio</h3>
	            <p>The Debt to Equity (D/E) ratio serves as a valuable indicator of a company's financial strength and
	              resilience. It highlights the proportion of capital financing sourced from lenders in comparison to
	              shareholder equity. A higher D/E ratio signifies a greater reliance on borrowing, which can increase the
	              risk of default during economic downturns. Consequently, risk-averse investors may prefer lower debt to
	              equity ratios. However, it's important to note that preferred D/E ratios may vary across industries.</p>
	            <p>The formula to calculate the Debt to Equity ratio is as follows:</p>
	            <p>D/E = Total Liabilities / Total Shareholder Equity</p>
	            <p>Where Total Shareholder Equity can be determined by subtracting Liabilities from Assets.</p>

	          </div>
	          <div class="investors pt-3" id="Debt-Asset">
	            <h3>Debt to Asset (D/A) Ratio</h3>
	            <p>The Debt to Asset (D/A) ratio is a valuable metric for comprehending a company's capital structure and
	              its ability to meet short and long-term debt obligations relative to its total assets. A higher D/A ratio
	              signifies a greater degree of leverage and reliance on lenders for financial solvency, potentially
	              exposing the company to risks associated with factors like rising interest rates.</p>
	            <p>Benjamin Graham, a renowned investor, recommended investing in companies with D/A ratios of less than
	              1.1, indicating a relatively low debt burden. To calculate the D/A ratio, you divide the total debt by the
	              total assets.</p>
	            <p>The formula for the Debt to Asset ratio is as follows:</p>
	            <p>D/A = Total Debt / Total Assets</p>
	          </div>
	          <div class="investors pt-3" id="Return-Equity">
	            <h3>Return on Equity (ROE)</h3>
	            <p>The Return on Equity (ROE) ratio is a valuable tool for analyzing a company's profitability over a
	              specific period, often compared to the sector's average. It is computed by dividing net income by the
	              average shareholder equity. A higher ROE suggests that a company can generate larger income values
	              relative to the proportionally smaller levels of equity financing, indicating efficient capital management
	              by the company to generate profits.</p>
	            <p>ROE is typically expressed as a percentage and can be calculated using the following formula: <br>ROE =
	              Net Income / Average Shareholder Equity <br>To calculate the Average Shareholder Equity for the period,
	              you use the formula provided below: <br>Average Shareholder Equity = (Beginning Shareholder Equity + End
	              Shareholder Equity) / 2 <br>Net Income is usually found in a company's Income Statement.</p>
	          </div>
	          <div class="investors pt-3" id="Invested-Capital">
	            <h3>Return on Invested Capital (ROIC)</h3>
	            <p>Return on Invested Capital (ROIC) is a key metric used to evaluate how effectively a company allocates
	              its financial resources for reinvestment into profitable ventures. It provides insights into whether a
	              company is efficiently utilizing capital over a specified period.</p>
	            <p>ROIC is typically expressed as a percentage and is analyzed in conjunction with a company's cost of
	              capital. The formula for calculating ROIC is as follows: <br>ROIC = (Net Income - Dividends) / (Debt +
	              Equity) <br>When assessing ROIC, it's essential to compare it to the Weighted Average Cost of Capital
	              (WACC). If ROIC is greater than the WACC, it suggests that the company is generating significant value for
	              its stakeholders. Conversely, if ROIC falls below the WACC, it indicates that the company is not
	              generating sufficient value and may be destroying value for the capital invested.</p>
	          </div>
	        </div>
	        <div class="glossary-content pb-5">
	          <h2>Glossary of Investment Terms</h2>
	          <div class="border-heading"></div>
	          <div class="investors pt-3" id="High-Low">
	            <h3>52-Week High and Low</h3>
	            <p>
	              As a technical indicator, a <b>52-week High and Low</b> refers to the highest and lowest trading prices of
	              a security or asset over the one-year period leading up to the present date. This information is often
	              used by investors and analysts to gauge the recent price range and potential volatility of a security.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Below-Market">
	            <h3>Above and Below The Market</h3>
	            <p>
	              This term describes an evaluation of the performance of a strategy, taking into account the prevailing
	              level of risk in the market. Essentially, it assesses how effectively a particular strategy has delivered
	              results given the existing market conditions and associated risks.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Alpha">
	            <h3>Alpha</h3>
	            <p>
	              <b>Alpha</b> (α) is a metric used to evaluate the performance of an investment strategy relative to the
	              broader market in terms of generating "abnormal" returns. It quantifies the degree to which you have
	              either outperformed or underperformed the returns of a benchmark index that is typically considered to
	              represent the overall movement of the market. Positive alpha indicates that your investment strategy
	              generated returns above what would be expected based on market conditions, while negative alpha suggests
	              underperformance compared to the market benchmark.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Beta">
	            <h3>Beta</h3>
	            <p>
	              <b>Beta</b> (β) is a metric that measures the volatility of a stock or portfolio in relation to the
	              broader market. It is used to assess how a stock's price tends to move in comparison to the overall
	              market. Beta is calculated by comparing the stock's historical price fluctuations to those of a benchmark
	              index, such as the S&amp;P 500.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Backtest">
	            <h3>Backtest</h3>
	            <p>
	              <b>Backtesting</b> is a systematic process that involves using historical data to simulate and evaluate
	              how a trading strategy would have performed over a selected time period, encompassing various market
	              conditions. This technique is usually conducted over an extensive historical window to encompass a wide
	              range of data and market scenarios. By default, many backtests are run for a duration of 10 years or more.
	              </p>
	              <p>
	              The performance of a backtested trading strategy is typically assessed in comparison to a benchmark index,
	              such as the FTSE100 or S&amp;P 500. This benchmark serves as a reference point against which the strategy's
	              performance can be measured, helping investors and analysts gauge the strategy's effectiveness and
	              potential for generating returns under different market conditions.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Benchmark">
	            <h3>Benchmark</h3>
	            <p>A benchmark is typically a well-known financial instrument that serves as a reference point, representing a broad segment of the market. It is used as a yardstick to measure and evaluate the performance of a specific investment strategy. Commonly used benchmarks include well-known indexes like the FTSE100 and S&amp;P 500.</p>
	            <p>In the context of your strategy, ETFs (Exchange-Traded Funds) tracking these benchmark indexes are often used as benchmarks. This practice ensures that the benchmark chosen is representative of the market in which you are investing.</p>
	            <p>The performance of a strategy is assessed by comparing it to its benchmark. A strategy can be considered to perform well if it achieves one or more of the following:</p>
	            <p><b>Better Overall Performance (Alpha):</b> The strategy generates returns that surpass the benchmark index, indicating that it has the potential to outperform the market.</p>
	            <p><b>Lower Volatility (Beta):</b> The strategy exhibits less price volatility compared to the benchmark, suggesting it may be less risky.</p>
	            <p><b>Better Risk-Adjusted Performance (Sharpe Ratio):</b> The strategy offers a higher risk-adjusted return, indicating that it generates more significant returns relative to the risk taken.</p>
	          </div>
	          <div class="investors pt-3" id="CO-Footprint">
	            <h3>CO2 Footprint</h3>
	            <p>Carbon emissions are typically measured in units of carbon dioxide equivalents (CO2e), which quantify the amount of carbon dioxide and other greenhouse gases that may be released into the atmosphere as a result of human activities. A "Carbon Footprint" refers to the total sum of all emissions associated with a particular entity, activity, or portfolio over a specified period of time. This metric is instrumental in helping individuals and organizations comprehend and assess the environmental impact and contribution to climate change associated with their actions, investments, or operations.</p>
	          </div>
	          <div class="investors pt-3" id="Correlation">
	            <h3>Correlation</h3>
	            <p>Correlation is a measure of the strength and direction of the relationship between two variables. When two variables move in the same direction, they are positively correlated, whereas if they move in opposite directions, they are negatively correlated. A negative or weak positive correlation between assets in a portfolio can help reduce overall portfolio volatility because these assets tend to offset each other's movements. On the other hand, when assets in a portfolio are positively correlated, they move in sync, which can lead to higher levels of risk since they are more likely to experience simultaneous gains or losses.</p>
	          </div>
	          <div class="investors pt-3" id="Diversification">
	            <h3>Diversification</h3>
	            <p>Enhance portfolio diversification by including a variety of stocks, different asset classes, and investments from various regions and sectors. Increased diversification helps reduce portfolio volatility. Typically, a larger and more diversified selection of assets is advisable for individuals with lower risk tolerance.</p>
	          </div>
	          <div class="investors pt-3" id="Dividends-represent">
	            <h3>Dividends</h3>
	            <p>Dividends represent a periodic allocation of a portion of a company's profits, typically distributed to shareholders in the form of either cash payments or additional stock. The decision to make dividend payments is typically made by the company's board of directors.</p>
	          </div>
	          <div class="investors pt-3" id="Environmental">
	            <h3>Environmental</h3>
	            <p>Evaluate the environmental impact of companies and formulate your investment strategy with a strong emphasis on those that align with your values. </p>
	            <p>Environmental considerations are a vital component of the ESG (Environmental, Social, and Governance) framework and encompass the ways in which a company's operations, either directly or indirectly, impact our natural environment.</p>
	            <p>Key environmental areas of concern include climate change, pollution and waste management, and the sustainable use of natural resources.</p>
	          </div>
	          <div class="investors pt-3" id="Governance">
	            <h3>Governance</h3>
	            <p>Choose to construct a strategy that consists of securities with high governance ratings, which are a vital component of the ESG (Environmental, Social, and Governance) framework. Governance, in this context, pertains to the established standards and procedures governing decision-making processes. It delves into the dynamics between the company's board of directors and shareholders, as well as the distribution of rights and responsibilities within the organization.</p>
	            <p>Effective governance standards encompass proficient reporting, well-defined policies, and transparent communication practices. These elements collectively contribute to a company's long-term success and stability.</p>
	          </div>
	          <div class="investors pt-3" id="Liquidity-refers">
	            <h3>Liquidity</h3>
	            <p>Liquidity refers to the degree of ease with which assets can be bought or sold in a market without causing significant fluctuations in market prices. For instance, when buy and sell orders are in equilibrium for an asset that is actively traded with high volumes, the market price remains relatively stable.</p>
	            <p>Cash is often considered the most liquid asset because it can be readily used to settle financial obligations and transactions quickly. Its high liquidity means it can be easily converted into other assets or used to cover outstanding liabilities without causing substantial price movements in the market.</p>
	          </div>
	          <div class="investors pt-3" id="MACD-Strategy">
	            <h3>MACD Strategy</h3>
	            <p>The Moving Average Convergence Divergence, commonly known as MACD, is a widely used indicator designed to identify shifts in market trends and generate buy or sell signals accordingly. Unlike traditional moving averages, which are based on simple arithmetic calculations (SMA), the MACD is constructed using Exponential Moving Averages (EMA).</p>
	            <p>In contrast to SMAs, which treat all data points equally and have uniform weighting, EMAs assign more significance or weight to recent price data. This design reflects the intuitive idea that recent price movements are more influenced by current market events and conditions.</p>
	          </div>
	          <div class="investors pt-3" id="Market-Capitalisation">
	            <h3>Market Capitalisation</h3>
	            <p>Market Capitalization, often abbreviated as 'Market Cap,' is the total value of a company's outstanding shares, calculated by multiplying the share price by the total number of shares.</p>
	          </div>
	          <div class="investors pt-3" id="Market-Close">
	            <h3>Market Close</h3>
	            <p>
	                Market close denotes the final trading price of a particular financial instrument at the end of a regular trading day.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Market-Open">
	            <h3>Market Open</h3>
	            <p>
	                Market open signifies the initial trading price of a specific financial instrument when an exchange commences trading at the beginning of a trading day.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Momentum">
	            <h3>Momentum</h3>
	            <p>
	                Momentum is calculated as the percentage change in price over the preceding six months. When momentum has a positive value, it indicates that the price has risen during that period, while negative values signify a decrease in price.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Momentum-Strategy">
	            <h3>Momentum Strategy</h3>
	            <p>
	                Momentum for an asset is calculated by measuring the percentage change in its value over a specified time frame. Positive momentum suggests that the asset may have the potential to continue rising, while negative momentum indicates a potential further decline in price.
	                <br>
	                The Momentum strategy is designed to identify assets with the most significant percentage price increases over the specified period and generates buy signals for these assets. Conversely, the strategy also identifies assets with the most substantial price decreases over the same period and generates sell signals for them. This approach aims to capitalize on the trends in asset prices and make investment decisions accordingly.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Lookback-Period">
	            <h3>Lookback Period</h3>
	            <p>
	                The lookback period, in the context of a backtest, refers to the specific duration over which performance measurements are computed within the backtest window. For instance, consider a Momentum strategy with a 6-month lookback period and a 10-year backtest window. In this scenario, if the strategy rebalances on a monthly basis, it means that every month, the strategy calculates the Momentum over the previous 6 months for all the instruments it's tracking. This calculation involves assessing the percentage change in prices over that 6-month period. The backtest then simulates this process over a historical time window spanning 10 years, enabling an evaluation of how the strategy would have performed during that extended period.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Portfolio-Construction">
	            <h3>Portfolio Construction</h3>
	            <p>
	                You can choose from a variety of methods to determine how your portfolio is constructed:
	            </p>

	            <p><strong>Equally Weighted:</strong> This method allocates the same proportion of funds to each security in your portfolio, ensuring an equal distribution of investment across all assets.</p>

	            <p><strong>Market Cap:</strong> Portfolio construction is based on a market capitalization weighting of each asset. Larger companies with higher market caps receive a larger allocation within the portfolio.</p>

	            <p><strong>Volatility Weighted:</strong> This approach calculates the level of volatility or risk associated with each security and assigns a higher weighting to less volatile instruments. It aims to reduce portfolio risk by giving greater importance to lower-risk assets.</p>

	            <p><strong>Variance Optimized Portfolio Construction:</strong> This method focuses on optimizing your portfolio for risk-adjusted returns. Securities are weighted in a manner that aims to maximize the portfolio's return while considering the associated risk. It seeks to strike a balance between potential returns and portfolio risk.</p>
	          </div>
	          <div class="investors pt-3" id="Return-metric">
	            <h3>Return</h3>
	            <p>
	                The Return metric reflects the profitability of your investment strategy and is calculated as the Internal Rate of Return (IRR) of your strategy's cash flows. It considers all investments made, interim dividends or sales, and assumes that the portfolio is sold at its current value today. The IRR represents the discount rate at which the Net Present Value (NPV) of the cash flows from the strategy becomes zero. In other words, it is the rate of return at which your strategy's cash flows break even in present value terms.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Risk-Level">
	            <h3>Risk Level</h3>
	            <p>
	                The risk associated with an investment strategy signifies the likelihood that the actual return on the investment may deviate from the expected return.
	            </p>
	            <p>
	                A low-risk strategy typically consists of a larger number of instruments, each of which has lower volatilities or price fluctuations. In contrast, higher-risk strategies may involve assets with greater price volatility. While higher-risk strategies offer the potential for greater returns, they also come with a heightened risk of more significant losses.
	            </p>

	            <p>Your chosen risk level reflects your risk appetite or propensity, indicating your willingness to either embrace or avoid risk in your investment approach. It's an essential consideration when tailoring your investment strategy to align with your financial objectives and tolerance for risk.</p>
	          </div>
	          <div class="investors pt-3" id="Sharpe-Ratio">
	            <h3>Sharpe Ratio</h3>
	            <p>
	                The Sharpe Ratio serves as a metric for assessing the risk-adjusted performance of your investment strategy. This ratio is computed by dividing the strategy's return by its volatility, which serves as a proxy for risk.
	            </p>
	            <p>
	                Here's how to interpret the Sharpe Ratio outcomes:
	            </p>
	            <p><b>High returns divided by low risk:</b> This scenario yields a high Sharpe ratio, which is the most favorable outcome. It indicates strong returns relative to the level of risk taken, signifying an attractive risk-adjusted performance.</p>
	            <p><b>Low returns divided by low risk:</b> This results in a medium Sharpe ratio, suggesting that returns are moderate compared to the associated risk.</p>
	            <p><b>High returns divided by high risk:</b> A medium Sharpe ratio is produced, indicating that while returns are good, they are offset by higher risk levels.</p>
	            <p><b>Low returns divided by high risk:</b> This leads to a low Sharpe ratio, which is the least favorable outcome. It signifies poor returns relative to the elevated risk taken, indicating an unattractive risk-adjusted performance.</p>
	          </div>
	          <div class="investors pt-3" id="Stamp-Duty">
	            <h3>Stamp Duty</h3>
	            <p>
	                Stamp duty is a tax imposed by the UK government on the acquisition of specific assets, which includes stocks. When purchasing UK stocks, a stamp duty of 0.5% is levied on the value of the transaction.
	            </p>
	            <p>
	                It's important to note that stamp duty is not applicable to various categories of assets, such as UK-listed Exchange-Traded Funds (ETFs), stocks listed on the AIM (Alternative Investment Market), or those listed on US exchanges, along with other non-UK assets. The exemptions help define the scope of assets subject to this tax.
	            </p>
	          </div>
	          <div class="investors pt-3" id="Volatility">
	            <h3>Volatility</h3>
	            <p>
	                Volatility is a metric that quantifies the extent of fluctuations in the returns of a specific security over a specified time period. In many instances, higher volatility is associated with increased risk for that security. This means that securities with greater volatility are generally considered riskier investments due to their potential for larger and more frequent price swings.
	            </p>
	          </div>  
	          <div class="investors pt-3" id="Value-Strategy">
	            <h3>Value Strategy</h3>
	            <p>
	                A value indicator aims to assess whether the price of an asset is trading above or below its intrinsic value. This assessment is made by analyzing a company's fundamental metrics, primarily based on its financial statement reports.
	            </p>
	            <p>
	                If the indicator determines that an instrument is undervalued, the value strategy will generate a buy signal, suggesting that the asset may be a favorable investment opportunity. Conversely, if the indicator identifies an asset as overvalued, the strategy will generate a sell signal, indicating that it may be prudent to divest or avoid the asset due to its potentially inflated price relative to its intrinsic worth.
	            </p>
	          </div>
	        </div>
	      </div>
	    </div>
	</div>
</template>

<script>
export default {
  name: "GlossarySidebar",
  data() {
    return {
      activeIndex: null, // Currently active accordion index
      accordionItems: [
        {
          title: "Understanding Risk",
          links: [
            { text: "Assessing Your Risk Tolerance", href: "#assessing" },
            { text: "Balancing Risk and Reward", href: "#Balancing" },
            { text: "Investor Profiles and Their Risk Preferences", href: "#Investor" },
            { text: "Contrasting Passive and Active Investment Strategies", href: "#Contrasting" },
          ],
        },
        {
          title: "Exploring Investment Strategies",
          links: [
            { text: "Fundamental Analysis vs. Technical Analysis", href: "#fundamental" },
            { text: "Defining Investment Strategy", href: "#investment" },
            { text: "Crafting a Well-Balanced Investment Portfolio", href: "#crafting" },
          ],
        },
        {
          title: "Types of Investment Strategies",
          links: [
            { text: "Exploring Momentum Investing", href: "#exploring" },
            { text: "Understanding Value Investing", href: "#value-investing" },
            { text: "The Moving Average Strategy in Depth", href: "#moving-average" },
            { text: "Demystifying Relative Strength Indicators", href: "#strength-indicators" },
            { text: "Exploring On-Balance Volume (OBV) in Investment", href: "#volume-investment" },
            { text: "Diving into Dividend Investing", href: "#dividend-Investing" },
            { text: "Comprehensive Guide to the Moving Average Convergence Divergence (MACD) Strategy", href: "#comprehensive" },
          ],
        },
        {
          title: "Sustainable Investment Approaches",
          links: [
            { text: "Understanding ESG Ratings and Their Significance", href: "#significance" },
            { text: "Assessing Carbon Emissions in Sustainable Investing", href: "#sustainable-investing" },
            { text: "Exploring Methane Emissions in Sustainable Investment Strategies", href: "#exploring-methane" },
          ],
        },
        {
          title: "Foundations of Investment",
          links: [
            { text: "Principles of Diversification in Investments", href: "#diversification-investments" },
            { text: "Understanding and Managing Volatility in Portfolios", href: "#understanding" },
            { text: "Exploring Correlation in Investment Assets", href: "#Investment-Assets" },
            { text: "Assessing Profitability Metrics in Investment Analysis", href: "#Assessing-Profitability" },
            { text: "The Significance of Rate of Return in Investments", href: "#Significance-Rate" },
            { text: "Calculating Expected Returns in Investment Projections", href: "#Investment-Projections" },
            { text: "A Key Factor of Liquidity", href: "#liquidity" },
            { text: "Capital Allocation", href: "#Capital-Allocation" },
            { text: "Dividends", href: "#Dividends" },
            { text: "Balance Sheets", href: "#Balance-Sheet" },
            { text: "Income Statements", href: "#Income-Statement" },
          ],
        },
        {
          title: "Financial Ratio Essentials",
          links: [
            { text: "Understanding the Dividend Payout Ratio", href: "#Payout-Ratio" },
            { text: "Analyzing the Dividend Per Share Ratio", href: "#Share-Ratio" },
            { text: "Earnings Per Share (EPS)", href: "#Per-Share" },
            { text: "Price to Earnings (P/E) Ratio", href: "#Earnings-Ratio" },
            { text: "Price to Book Value (P/BV) Ratio", href: "#Value-Ratio" },
            { text: "Net Asset Value (NAV)", href: "#Asset-Value" },
            { text: "Current Ratio", href: "#Current-Ratio" },
            { text: "Quick Ratio", href: "#Quick-Ratio" },
            { text: "Debt to Equity Ratio", href: "#Equity-Ratio" },
            { text: "Debt to Asset Ratio", href: "#Debt-Asset" },
            { text: "Return on Equity (ROE)", href: "#Return-Equity" },
            { text: "Return on Invested Capital (ROIC)", href: "#Invested-Capital" },
          ],
        },
        {
          title: "Glossary of Investment Terms",
          links: [
            { text: "52-Week High and Low", href: "#High-Low" },
            { text: "Above and Below The Market", href: "#Below-Market" },
            { text: "Alpha", href: "#Alpha" },
            { text: "Beta", href: "#Beta" },
            { text: "Backtest", href: "#Backtest" },
            { text: "Benchmark", href: "#Benchmark" },
            { text: "CO2 Footprint", href: "#CO-Footprint" },
            { text: "Correlation", href: "#Correlation" },
            { text: "Diversification", href: "#Diversification" },
            { text: "Dividends", href: "#Dividends-represent" },
            { text: "Environmental", href: "#Environmental" },
            { text: "Governance", href: "#Governance" },
            { text: "Liquidity", href: "#Liquidity-refers" },
            { text: "MACD Strategy", href: "#MACD-Strategy" },
            { text: "Market Capitalization", href: "#Market-Capitalisation" },
            { text: "Market Close", href: "#Market-Close" },
            { text: "Market Open", href: "#Market-Open" },
            { text: "Momentum", href: "#Momentum" },
            { text: "Momentum Strategy", href: "#Momentum-Strategy" },
            { text: "Lookback Period", href: "#Lookback-Period" },
            { text: "Portfolio Construction", href: "#Portfolio-Construction" },
            { text: "Return", href: "#Return-metric" },
            { text: "Risk Level", href: "#Risk-Level" },
            { text: "Sharpe Ratio", href: "#Sharpe-Ratio" },
            { text: "Stamp Duty", href: "#Stamp-Duty" },
            { text: "Volatility", href: "#Volatility" },
            { text: "Value Strategy", href: "#Value-Strategy" },
          ],
        },
      ],
    };
  },
  methods: {
    toggleAccordion(index) {
      this.activeIndex = this.activeIndex === index ? null : index;
    },
  },
};
</script>

<style scoped>
.gloss-sidebar {
  position: sticky;
  top: 50px;
  width: 300px;
  max-height: calc(100vh - 40px);
  overflow-y: auto;
  padding: 20px;
  background-color: #ffffff;
  border-right: 1px solid #e0e0e0;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
  border-radius: 8px;
}
.glossary-content ul{
	font-size: 16px;
	line-height: 24px;
}
.glossary-content ul > li > ul{
	line-height: 32px;
}

.gloss-sidebar h3 {
  margin-bottom: 20px;
  font-size: 1.6rem;
  color: #333333;
  border-bottom: 2px solid #e0e0e0;
  padding-bottom: 10px;
}

.accordion {
  width: 100%;
}

.accordion-item {
  border-bottom: 1px solid #e0e0e0;
}

.accordion-button {
  width: 100%;
  text-align: left;
  padding: 12px 16px;
  font-size: 1rem;
  font-weight: 500;
  color: #333333;
  background-color: #f9f9f9;
  border: none;
  outline: none;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: background-color 0.3s ease;
}

.accordion-button:hover {
  background-color: #f1f1f1;
}

.accordion-button.active {
  background-color: #e0e0e0;
}

.accordion-button .indicator {
  display: flex;
  align-items: center;
}

.accordion-collapse {
  padding: 0 16px 16px 16px;
  animation: fadeIn 0.3s ease-in-out;
}

.accordion-body ul {
  list-style: none;
  padding-left: 0;
  margin: 0;
}

.accordion-body li {
  margin-bottom: 10px;
}

.accordion-body a {
  text-decoration: none;
  color: #000000;
  transition: color 0.2s;
  font-size: 16px;
}

.accordion-body a:hover {
  color: #0056b3;
}

/* Custom Scrollbar */
.gloss-sidebar::-webkit-scrollbar {
  width: 8px;
}

.gloss-sidebar::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.gloss-sidebar::-webkit-scrollbar-thumb {
  background-color: #c1c1c1;
  border-radius: 4px;
}

/* Fade-in Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive Design */
@media (max-width: 1024px) {
  .gloss-sidebar {
    width: 250px;
    padding: 16px;
  }

  .gloss-sidebar h3 {
    font-size: 1.4rem;
  }

  .accordion-button {
    padding: 10px 14px;
    font-size: 0.95rem;
  }

  .accordion-collapse {
    padding: 0 14px 14px 14px;
  }
}

@media (max-width: 768px) {
  .gloss-sidebar {
    width: 100%;
    max-height: none;
    position: relative;
    box-shadow: none;
    border-right: none;
    border-bottom: 1px solid #e0e0e0;
  }

  .gloss-sidebar h3 {
    font-size: 1.5rem;
    padding-bottom: 8px;
    border-bottom: none;
    margin-bottom: 16px;
  }

  .accordion-button {
    padding: 12px 10px;
    font-size: 1rem;
  }

  .accordion-collapse {
    padding: 0 10px 10px 10px;
  }
}
</style>
